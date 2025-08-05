<?php
namespace App\Controllers;
use App\Utils\Auth;

class DebugController
{
    public function sessionTest()
    {
        
  
        
        if (!isset($_SESSION['counter'])) {
            $_SESSION['counter'] = 1;
        } else {
            $_SESSION['counter']++;
        }
        
        echo "Contatore: " . $_SESSION['counter'];
    }
    
    public function dump()
    {
        session_start();
        echo '<pre>';
        var_dump('LOGGED USER:', Auth::user());
        var_dump($_SESSION);
        echo '</pre>';
        exit;
    }
}

