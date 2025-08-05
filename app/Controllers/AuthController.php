<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\User;
use App\Models\Passwordreset;
use App\Utils\Auth;
use App\Utils\Flash;
use App\Utils\Helper;
use App\Utils\Validator;
use App\Utils\Mailer;
use App\Utils\RememberMe;
use App\Utils\LoginThrottle;
use App\Utils\TwoFactor;
use App\Utils\Logger;
use App\Helpers\AvatarHelper;

class AuthController
{
    public function showLoginForm()
    {
        View::render('auth/login', ['title' => 'Accesso']);
    }
    
    public function login()
    {
        $data = $_POST;
        
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ];
        
        $validator = new Validator($data, $rules);
        
        if (!$validator->isValid()) {
            Logger::warning('Login fallito - Validazione non superata', [
                'email' => $data['email'] ?? null,
                'errors' => $validator->getErrors()
            ]);
            
            Flash::error($validator->getErrors());
            Helper::redirect('/login');
        }
        
        $throttle = new LoginThrottle($data['email']);
        if ($throttle->isBlocked($data['email'])) {
            Logger::warning('Login bloccato - Troppi tentativi falliti', [
                'email' => $data['email']
            ]);
            
            Flash::error(__('too_many_attempts_try_again_later'));
            Helper::redirect('/login');
        }
        
        $user = (new User())->getByEmail($data['email']);
        
        if (!$user || !password_verify($data['password'], $user->password)) {
            $throttle->increment($data['email']);
            
            Logger::warning('Login fallito - Credenziali non valide', [
                'email' => $data['email']
            ]);
            
            Flash::error(__('invalid_credentials'));
            Helper::redirect('/login');
        }
        
        if (!$user->is_active) {
            Logger::info('Login rifiutato - Account non attivo', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);
            
            Flash::error(__('account_not_active'));
            Helper::redirect('/login');
        }
        
        // ✅ Log login riuscito
        Logger::info('Login riuscito (fase 1) - In attesa verifica 2FA', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);
        
        // ✅ 2FA attivo — prepara sessione temporanea
        $_SESSION['2fa_pending']  = true;
        $_SESSION['2fa_user_id']  = $user->id;
        
        // ✅ Genera e invia codice 2FA
        $code = TwoFactor::generateCode($user->id);
        Mailer::send2FACode($user->email, $code);
        
        // ✅ Ricorda se ha richiesto "remember me" (memorizziamo flag temporaneamente)
        if (!empty($data['remember'])) {
            $_SESSION['remember_me'] = true;
        }
        
        // ✅ Reindirizza alla pagina di verifica 2FA
        Helper::redirect('/verify-2fa');
    }
    
    public function logout()
    {
        Auth::logout();
        Flash::success(__('logout_performed'));
        Helper::redirect('/login');
    }
    
    public function showRegisterForm()
    {
        View::render('auth/register', ['title' => 'Registrazione']);
    }
    
    public function register()
    {
        $data = $_POST;
        
        // Non includere password nei log
        $logData = $data;
        unset($logData['password'], $logData['password_confirm']);
        
        Logger::debug('Tentativo di registrazione utente', ['data' => $logData], 'register.log');
        
        $rules = [
            'firstname'         => 'required|min:2|max:50',
            'lastname'          => 'required|min:2|max:50',
            'username'          => 'required|alpha_num|min:3|max:30|unique:users,username',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|min:8|max:16|password_complex',
            'password_confirm'  => 'required|match:password',
            'avatar'            => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        ];
        
        $validator = new Validator($data, $rules);
        
        if (!$validator->isValid()) {
            Logger::error('Validazione fallita', ['errors' => $validator->errors()], 'register.log');
            
            foreach ($validator->errors() as $fieldErrors) {
                foreach ($fieldErrors as $error) {
                    Flash::error($error);
                }
            }
            Helper::redirect('/register');
        }
        
        try {
            Logger::debug("Inizio registrazione. Preparo i dati...", [], 'register.log');
            
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $data['activation_token'] = bin2hex(random_bytes(32));
            $data['is_active'] = 0;
            
            unset($data['csrf_token'], $data['password_confirm']);
            
            Logger::debug("Dati utente preparati", ['data' => $logData], 'register.log');
            
            // ✅ Gestione avatar con helper
            if (!empty($_FILES['avatar']['name'])) {
                $data['avatar'] = AvatarHelper::handle($_FILES['avatar'], 'register.log');
                if (!$data['avatar']) {
                    Flash::error(__('error_loading_image'));
                    Helper::redirect('/register');
                }
            }
            
            // ✅ Creazione utente
            $userId = (new User())->create($data);
            if (!$userId) {
                Logger::error("Creazione utente fallita. Nessun ID restituito", [], 'register.log');
                Flash::error(__('error_during_registration_please_try_again'));
                Helper::redirect('/register');
            }
            
            Logger::debug("Utente creato", ['user_id' => $userId], 'register.log');
            
            Mailer::sendActivationEmail($data['email'], $data['activation_token']);
            Logger::debug("Email inviata", ['email' => $data['email']], 'register.log');
            
            Flash::success(__('check_your_email_to_activate_your_account'));
            Helper::redirect('/login');
            
        } catch (\Exception $e) {
            Logger::error('Errore registrazione', ['exception' => $e->getMessage()], 'register.log');
            Logger::error('Traccia', ['trace' => $e->getTraceAsString()], 'register.log');
            Flash::error(__('internal_error_please_try_again_later'));
            Helper::redirect('/register');
        }
    }
    
    
    public function activate($token = null)
    {
        if (!$token) {
            Logger::warning('Attivazione fallita - Token mancante', [
                'token' => null,
                'ip' => $_SERVER['REMOTE_ADDR'] ?? 'CLI'
            ]);
            
            Flash::error(__('missing_token'));
            Helper::redirect('/login');
        }
        
        $user = (new User())->getByToken($token);
        
        if (!$user) {
            Logger::warning('Attivazione fallita - Token non valido o account già attivo', [
                'token' => $token,
                'ip' => $_SERVER['REMOTE_ADDR'] ?? 'CLI'
            ]);
            
            Flash::error(__('invalid_token_or_account_already_activated'));
            Helper::redirect('/login');
        }
        
        // Aggiorna l'utente: attiva l'account e azzera il token
        (new User())->update($user->id, [
            'is_active' => 1,
            'activation_token' => null
        ]);
        
        Logger::info('Account attivato con successo', [
            'user_id' => $user->id,
            'email'   => $user->email,
            'ip'      => $_SERVER['REMOTE_ADDR'] ?? 'CLI'
        ]);
        
        Flash::success(__('account_successfully_activated_you_can_now_log_in'));
        Helper::redirect('/login');
    }
    
    public function showForgotForm()
    {
        View::render('auth/forgot-password', ['title' => 'Password dimenticata']);
    }
    
    public function sendResetLink()
    {
        $email = $_POST['email'] ?? '';
        $user = (new User())->getByEmail($email);
        
        if ($user) {
            $token = bin2hex(random_bytes(32));
            
            (new Passwordreset())->createOrUpdate($email, $token);
            Mailer::sendPasswordReset($email, $token);
            
            Logger::info('Link di reset inviato con successo', [
                'user_id' => $user->id,
                'email' => $email,
                'ip' => $_SERVER['REMOTE_ADDR'] ?? 'CLI'
            ]);
        } else {
            Logger::warning('Tentativo di reset password per email non registrata', [
                'email' => $email,
                'ip' => $_SERVER['REMOTE_ADDR'] ?? 'CLI'
            ]);
        }
        
            Flash::success(__('recovery_email_sent_if_address_is_valid'));
            Helper::redirect('/forgot-password');
    }
    
    public function showResetForm($token = '')
    {
        $reset = new Passwordreset();
        
        if (!$reset->isValid($token)) {
            Flash::error(__('token_expired_or_invalid'));
            Helper::redirect('/forgot-password');
        }
        
        View::render('auth/reset-password', ['token' => $token, 'title' => 'Reimposta Password']);
    }
    
    public function resetPassword()
    {
        $data = $_POST;
        
        $validator = new Validator($data, [
            'token'            => 'required',
            'password'         => 'required|min:8',
            'password_confirm' => 'required|match:password'
        ]);
        
        $reset = new Passwordreset();
        $email = $reset->getEmailByToken($data['token']);
        
        if (!$email) {
            Logger::warning('Tentativo di reset con token non valido', [
                'token' => $data['token'] ?? null,
                'ip'    => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);
            
            Flash::error(__('invalid_token'));
            Helper::redirect('/forgot-password');
        }
        
        if ($validator->isValid()) {
            $user = (new User())->getByEmail($email);
            (new User())->update($user->id, [
                'password' => password_hash($data['password'], PASSWORD_DEFAULT)
            ]);
            $reset->delete($data['token']);
            
            Logger::info('Password reimpostata con successo', [
                'user_id' => $user->id,
                'email'   => $user->email,
                'ip'      => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);
            Flash::success(__('password_updated'));
            Helper::redirect('/login');
        } else {
            Logger::warning('Validazione fallita nel reset password', [
                'errors' => $validator->getErrors(),
                'ip'     => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);
            
            Flash::error($validator->getErrors());
            Helper::redirect('/reset-password/' . $data['token']);
        }
    }
}
