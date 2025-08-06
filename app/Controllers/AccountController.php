<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\User;
use App\Utils\Auth;
use App\Utils\Flash;
use App\Utils\Helper;
use App\Utils\Validator;
use App\Helpers\AvatarHelper;
use App\Utils\Csrf;
use App\Utils\Logger;

class AccountController
{
    protected $userModel;

    public function __construct()
    {
        Auth::requireLogin();
        $this->userModel = new User();
    }
    
    public function index(int $id)
    {
        $user = $this->userModel->getById($id);
        
        View::render('account/index', [
            'user' => $user,
            'title' => 'Profilo Utente'
        ]);
    }

    public function edit(int $id)
    {
        $user = $this->userModel->getById($id);
        
        View::render('account/edit', [
            'user' => $user,
            'title' => 'Modifica Profilo'
        ]);
    }

    public function update($id)
    {
        // ✅ Sanifica e pulisci i dati
        $data = Helper::cleanPost($_POST);
        
        // ✅ Verifica CSRF
        if (!Csrf::verifyToken($_POST['csrf_token'] ?? '')) {
            Logger::warning('CSRF token non valido nel profilo', [
                'user_id' => $id,
                'ip'      => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);
            Flash::error(__('invalid_csrf_token_please_try_again'));
            Helper::redirect("/account/edit/$id");
        }
        
        // ✅ Regole di validazione
        $rules = [
            'firstname'     => 'required|min:2|max:50',
            'lastname'      => 'required|min:2|max:50',
            'username'      => 'required|alpha_num|min:3|max:30|unique:users,username,' . $id,
            'email'         => 'required|email|unique:users,email,' . $id,
            'phone'         => 'required|regex:/^\d{10}$/',
            'bio'           => 'nullable|max:500',
            'address'       => 'nullable|min:3|max:100',
            'city'          => 'nullable|min:2|max:50',
            'postal_code'   => 'nullable|regex:/^\d{5}$/',
            'province'      => 'nullable|min:2|max:50',
            'country'       => 'nullable|min:2|max:50',
        ];
        
        $validator = new Validator($data, $rules);
        
        // ✅ Gestione avatar con helper
        if (!empty($_FILES['avatar']['name'])) {
            $data['avatar'] = AvatarHelper::handle($_FILES['avatar'], 'profile.log');
            if (!$data['avatar']) {
                $validator->addError('avatar', __('error_loading_image'));
            }
        } else {
            unset($data['avatar']);
        }
        
        // ✅ Se validazione OK → aggiorna
        if ($validator->passes()) {
            $this->userModel->update($id, $data);
            
            Logger::info('Profilo aggiornato con successo', [
                'user_id' => $id,
                'ip'      => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);
            
            Flash::success(__('profile_successfully_updated'));
        } else {
            Logger::warning('Validazione fallita nell\'aggiornamento profilo', [
                'user_id' => $id,
                'errors'  => $validator->getErrors(),
                'ip'      => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);
            
            foreach ($validator->errors() as $errors) {
                foreach ($errors as $error) {
                    Flash::error($error);
                }
            }
        }
        
        Helper::redirect("/account/edit/$id");
    }
    
    

    public function changePasswordForm($id)
    {
        $user = $this->userModel->getById($id);
        
        View::render('user/change-password', [
            'user' => $user,
            'title' => 'Cambia Password'
        ]);
    }

    public function updatePassword($id)
    {
        $data = Helper::cleanPost($_POST);
        
        // ✅ Verifica il token CSRF
        if (!Csrf::verifyToken($_POST['csrf_token'] ?? '')) {
            Logger::warning('CSRF token non valido nel cambio password', [
                'user_id' => $id,
                'ip'      => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);
            
            Flash::error(__('invalid_csrf_token_please_try_again'));
            Helper::redirect("/user/change-password/$id");
        }
        
        // ✅ Recupera l'utente dal DB
        $user = $this->userModel->findById($id);
        
        // ✅ Verifica password attuale
        if (!password_verify($data['current_password'] ?? '', $user->password)) {
            Logger::warning('CSRF token non valido nel cambio password', [
                'user_id' => $id,
                'ip'      => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);
            
            Flash::error(__('the_current_password_is_not_correct'));
            Helper::redirect("/user/change-password/$id");
        }
        
        // ✅ Regole per nuova password
        $rules = [
            'new_password'        => 'required|min:8|max:16|password_complex',
            'confirm_password'    => 'required|match:new_password',
        ];
        
        $validator = new Validator($data, $rules);
        
        if ($validator->passes()) {
            $this->userModel->update($id, [
                'password' => password_hash($data['new_password'], PASSWORD_DEFAULT)
            ]);
            
            Logger::info('Password aggiornata con successo', [
                'user_id' => $id,
                'ip'      => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);
            
            Flash::success(__('password_updated_correctly'));
            Helper::redirect('/user/dashboard');
        } else {
            Logger::warning('Validazione fallita nel cambio password', [
                'user_id' => $id,
                'errors'  => $validator->getErrors(),
                'ip'      => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);
            
            foreach ($validator->errors() as $errors) {
                foreach ($errors as $error) {
                    Flash::error($error);
                }
            }
            
            Helper::redirect("/user/change-password/$id");
        }
    }
    
    public function devices()
    {
        Auth::requireLogin();
        $userId = Auth::id();
        $devices = (new \App\Models\UserDevice())->getByUser($userId);
        View::render('account/devices', compact('devices'));
    }
    
    
}
