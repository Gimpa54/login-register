<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\User;
use App\Utils\Auth;
use App\Utils\Flash;
use App\Utils\Helper;
use App\Utils\Validator;
use App\Utils\Uploader;
use App\Utils\Csrf;
use App\Utils\Logger;

class AdminUserController
{
    protected $userModel;
    
    public function __construct()
    {
        Auth::requireAdmin();
        $this->userModel = new User();
    }
    
    public function index()
    {
        $search = $_GET['search'] ?? '';
        $role = $_GET['role'] ?? '';
        
        $results = $this->userModel->searchPaginated($search, $role);
        
        View::render('admin/users/index', [
            'users' => $results['data'],
            'pagination' => $results['pagination']->links('/admin/users'),
            'search' => $search,
            'role' => $role,
            'title' => 'Gestione Utenti'
        ]);
    }
    
    public function edit($id)
    {
        $user = $this->userModel->findById($id);
        
        if (!$user) {
            Flash::error(__('user_not_found'));
            Helper::redirect('/admin/users');
        }
        
        View::render('admin/users/edit', [
            'user' => $user,
            'title' => 'Modifica Utente'
        ]);
    }
    
    public function update($id)
    {
        $data = $_POST;
        
        // ✅ Rimuovi csrf_token dal POST
        $data = Helper::cleanPost($_POST);
        
        // ✅ Verifica il token CSRF
        if (!Csrf::verifyToken($_POST['csrf_token'] ?? '')) {
            Logger::warning('CSRF token non valido nell\'aggiornamento utente', [
                'user_id' => $id,
                'ip'      => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);
            
            Flash::error(__('invalid_csrf_token'));
            Helper::redirect("/admin/users/edit/$id");
        }
        
        $rules = [
            'firstname'  => 'required',
            'lastname'  => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role'  => 'required|in:admin,moderator,user',
        ];
        
        $validator = new Validator($data, $rules);
        
        // Validazione avatar (opzionale)
        if (!empty($_FILES['avatar']['name'])) {
            try {
                $data['avatar'] = Uploader::upload(
                    $_FILES['avatar'],
                    'storage/avatars',
                    ['jpg', 'jpeg', 'png'],
                    2 // max size in MB
                    );
            } catch (\Exception $e) {
                $validator->addError('avatar', $e->getMessage());
                
                Logger::warning('Errore upload avatar durante aggiornamento utente', [
                    'user_id' => $id,
                    'error'   => $e->getMessage(),
                    'ip'      => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
                ]);
            }
        }
        
        if ($validator->passes()) {
            $this->userModel->update($id, $data);
            
            Logger::info('Utente aggiornato con successo', [
                'user_id' => $id,
                'admin_id' => Auth::id(), // se disponibile
                'ip'      => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);
            
            Flash::success(__('user_successfully_updated'));
        } else {
            Logger::info('Utente aggiornato con successo', [
                'user_id' => $id,
                'admin_id' => Auth::id(), // se disponibile
                'ip'      => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);
            
            Flash::error($validator->getErrors());
        }
        Helper::redirect("/admin/users");
    }
    
    
    public function toggleStatus($id)
    {
        $user = $this->userModel->findById($id);
        
        if ($user) {
            $this->userModel->update($id, ['active' => !$user->active]);
            
            Logger::info('Stato utente aggiornato', [
                'user_id'   => $id,
                'new_state' => $newStatus ? 'attivo' : 'disattivo',
                'admin_id'  => Auth::id(), // opzionale se disponibile
                'ip'        => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);
            
            Flash::success(__('updated_status'));
        } else {
            Logger::warning('Tentativo di aggiornare stato utente non esistente', [
                'user_id' => $id,
                'ip'      => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);
        }
        
        Helper::redirect('/admin/users');
    }
    
    public function profile($id)
    {
        $user = $this->userModel->findById($id);
        
        if (!$user) {
            Logger::warning('Tentativo di accesso a profilo non esistente', [
                'user_id' => $id,
                'ip'      => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);
            
            Flash::error(__('profile_not_found'));
            Helper::redirect('/admin/users');
        }
        
        Logger::info('Visualizzazione profilo utente da parte di admin', [
            'user_id'  => $id,
            'admin_id' => Auth::id(), // opzionale se disponibile
            'ip'       => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ]);
        
        View::render('admin/users/profile', [
            'user' => $user,
            'title' => "Profilo di {$user->firstname}"
            ]);
    }
}
