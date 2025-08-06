<?php

use App\Core\Router;

// ==============================
// Pagina iniziale
// ==============================
Router::get('/', 'HomeController@index');

// ==============================
// Autenticazione
// ==============================
Router::get('/login', 'AuthController@showLoginForm', ['guest', 'locale']);
Router::post('/login', 'AuthController@login', ['guest', 'csrf', 'locale']);
Router::get('/register', 'AuthController@showRegisterForm', ['guest'. 'locale']);
Router::post('/register', 'AuthController@register', ['guest', 'csrf', 'locale']);
Router::get('/logout', 'AuthController@logout', ['auth', 'session']);

// ==============================
// Password dimenticata e reset
// ==============================
Router::get('/forgot-password', 'AuthController@showForgotForm', ['guest', 'locale']);
Router::post('/forgot-password', 'AuthController@sendResetLink', ['guest', 'csrf', 'locale']);
Router::get('/reset-password/{token}', 'AuthController@showResetForm', ['guest', 'locale']);
Router::post('/reset-password', 'AuthController@resetPassword', ['guest', 'csrf', 'locale']);

// ==============================
// Attivazione account
// ==============================
Router::get('/activate/{token}', 'AuthController@activate', ['guest']);

// ==============================
// Verifica 2FA
// ==============================
Router::get('/verify-2fa', 'TwoFactorController@show', ['auth']);
Router::post('/verify-2fa', 'TwoFactorController@verify', ['auth', 'csrf']);
Router::get('/resend-2fa', 'TwoFactorController@resend', ['auth']);

// ==============================
// Dashboard utente
// ==============================
Router::get('/user/dashboard', 'UserController@dashboard', ['session', 'auth', '2fa']);
Router::get('/user/change-password/{id}', 'AccountController@changePasswordForm', ['auth', 'session']);
Router::post('/user/change-password/{id}', 'AccountController@updatePassword', ['auth', 'csrf', 'session']);

// ==============================
// Account
// ==============================
Router::get('/account/edit/{id}', 'AccountController@edit', ['auth', 'session']);
Router::get('/account/devices', 'AccountController@devices', ['auth', 'session']);
Router::get('/account/{id}', 'AccountController@index', ['auth', 'session']);
Router::post('/account/edit/{id}', 'AccountController@update', ['auth', 'session']);


// ==============================
// Tema e lingua
// ==============================
//Router::get('/theme/{theme}', 'ThemeController@switch');
Router::get('/lang/{lang}', 'LangController@switch');

Router::get('/theme/toggle', 'ThemeController@toggle');
Router::get('/lang/{lang}', 'LangController@set');

// ==============================
// Amministrazione utenti
// ==============================
Router::get('/admin/users', 'AdminUserController@index', ['auth', 'admin', 'session']);
Router::get('/admin/users/profile/{id}', 'AdminUserController@profile', ['auth', 'admin', 'session']);
Router::get('/admin/users/edit/{id}', 'AdminUserController@edit', ['auth', 'admin', 'session']);
Router::post('/admin/users/edit/{id}', 'AdminUserController@update', ['auth', 'admin', 'csrf', 'session']);
Router::post('/admin/users/toggle/{id}', 'AdminUserController@toggle', ['auth', 'admin', 'csrf', 'session']);
Router::get('/admin/security-log', 'AdminSecurityController@index', ['auth', 'admin', 'session']);
Router::get('/admin/logs', 'AdminLogController@index', ['auth', 'admin', 'session']);
Router::get('/admin/logs/export-csv', 'AdminLogController@exportCsv', ['auth', 'admin', 'session']);
Router::get('/admin/logs/export-pdf', 'AdminLogController@exportPdf', ['auth', 'admin', 'session']);





