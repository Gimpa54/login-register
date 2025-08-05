<?php
namespace App\Controllers;

use App\Core\View;
use App\Utils\Auth;

class HomeController
{
    public function index()
    {
        $user = Auth::check() ? Auth::user() : null;
        
        View::render('home/index', [
            'title' => __('welcome_to_login_and_registration'),
            'user' => $user
        ]);
    }
}