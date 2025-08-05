<?php
namespace App\Controllers;

use App\Core\View;
use App\Utils\Auth;
use App\Utils\Helper;

class UserController
{
    public function __construct()
    {
        Auth::requireLogin();
    }

    /**
     * Dashboard dell'utente autenticato
     */
    public function dashboard()
    {
        $user = Auth::user();

        View::render('user/dashboard', [
            'user' => $user,
            'title' => __('my_dashboard')
        ]);
    }

    /**
     * Visualizza il proprio profilo (pagina alternativa)
     */
    public function profile()
    {
        $user = Auth::user();

        View::render('account/edit', [
            'user' => $user,
            'title' => __('my_profile')
        ]);
    }

    /**
     * Mostra il form per il cambio password
     */
    public function changePassword()
    {
        View::render('user/change-password', [
            'title' => __('change_your_password')
        ]);
    }
}

