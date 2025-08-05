<?php 
namespace App\Controllers;

use App\Core\View;
use App\Models\User;
use App\Utils\Flash;
use App\Utils\Helper;
use App\Utils\Auth;
use App\Utils\TwoFactor;
use App\Utils\Mailer;
use App\Utils\RememberMe;
use App\Utils\Logger;

class TwoFactorController
{
    public function show()
    {
        if (!isset($_SESSION['2fa_pending']) || !$_SESSION['2fa_user_id']) {
            Helper::redirect('/login');
        }
        
        View::render('auth/verify-2fa', [
            'title' => __('two_step_verification')
        ]);
    }
    
    public function verify()
    {
        $code = $_POST['code'] ?? '';
        //var_dump('CODE POST:', $code);
        $userId = $_SESSION['2fa_user_id'] ?? null;
        //var_dump('2FA USER ID:', $userId);exit();
        
        if ($userId && TwoFactor::verify((int)$code)) {
            
            // ✅ Ottieni utente
            $user = Auth::getUserById($userId);
            
            if (!$user) {
                Logger::warning('2FA fallita: utente non trovato', [
                    'user_id' => $userId,
                    'ip'      => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
                ]);
                
                Flash::error(__('user_not_found'));
                Helper::redirect('/login');
            }
            
            // ✅ Pulisci sessione 2FA
            unset($_SESSION['2fa_pending'], $_SESSION['2fa_user_id']);
            
            // ✅ Login
            Auth::login($user);
            
            // ✅ Remember Me
            if (!empty($_SESSION['remember_me'])) {
                RememberMe::create($user->id);
                unset($_SESSION['remember_me']);
            }
            
            Logger::info('Autenticazione 2FA riuscita', [
                'user_id' => $user->id,
                'ip'      => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);
            
            // ✅ Vai alla dashboard
            Helper::redirect('/user/dashboard');
        }
        
        Logger::warning('Codice 2FA errato o scaduto', [
            'user_id' => $userId,
            'code'    => $code,
            'ip'      => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ]);
        
        // ❌ Fallimento
        Flash::error(__('wrong_or_expired_code'));
        Helper::redirect('/verify-2fa');
    }
    
    
    public function resend()
    {
        $userId = $_SESSION['2fa_user_id'] ?? null;
        
        if (!$userId) {
            Logger::warning('Richiesta di invio codice 2FA senza sessione valida', [
                'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);
            
            Helper::redirect('/login');
        }
        
        $user = Auth::getUserById($userId);
        
        if (!$user) {
            Logger::warning('Tentativo di invio codice 2FA per utente non trovato', [
                'user_id' => $userId,
                'ip'      => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);
            
            Flash::error(__('user_not_found'));
            Helper::redirect('/login');
        }
        
        $code = TwoFactor::generateCode($userId);
        Mailer::send2FACode($user->email, $code);
        
        Logger::warning('Tentativo di invio codice 2FA per utente non trovato', [
            'user_id' => $userId,
            'ip'      => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ]);
        
        Flash::success(__('new_code_sent_to_your_email'));
        Helper::redirect('/verify-2fa');
    }
}
