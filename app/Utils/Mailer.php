<?php
namespace App\Utils;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Utils\Env;

class Mailer
{
    protected PHPMailer $mail;
    
    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        
        $this->setup();
    }
    
    protected function setup(): void
    {
        $this->mail->isSMTP();
        $this->mail->Host       = env('MAIL_HOST');
        $this->mail->Port       = env('MAIL_PORT', 587);
        $this->mail->CharSet    = 'UTF-8';
        $this->mail->setFrom(env('MAIL_FROM'), env('MAIL_FROM_NAME'));
        
        // Gestione autenticazione dinamica
        $username = env('MAIL_USERNAME');
        $password = env('MAIL_PASSWORD');
        $this->mail->SMTPAuth  = !empty($username) && !empty($password);
        
        if ($this->mail->SMTPAuth) {
            $this->mail->Username = $username;
            $this->mail->Password = $password;
            $this->mail->SMTPSecure = env('MAIL_ENCRYPTION', 'tls');
        } 
    }
    
    public function to(string $email, string $name = ''): self
    {
        $this->mail->addAddress($email, $name);
        return $this;
    }
    
    public function subject(string $subject): self
    {
        $this->mail->Subject = $subject;
        return $this;
    }
    
    public function body(string $html, string $alt = ''): self
    {
        $this->mail->isHTML(true);
        $this->mail->Body = $html;
        $this->mail->AltBody = $alt ?: strip_tags($html);
        return $this;
    }
    
    public function send(): bool
    {
        try {
            return $this->mail->send();
        } catch (Exception $e) {
            Logger::error('Mailer Error: ' . $this->mail->ErrorInfo);
            return false;
        }
    }
    
    public static function sendPasswordReset(string $email, string $token): bool
    {
        $link = env('APP_URL') . "/reset-password/$token";
        
        $subject = __('recover_your_password');
        $html = "<p>" . __('click_on_the_link_to_reset_your_password') . " :</p><p><a href=\"$link\">$link</a></p>";
        
        $mailer = new self();
        return $mailer
        ->to($email)
        ->subject($subject)
        ->body($html)
        ->send();
    }
    
    public static function send2FACode(string $email, string $code): bool
    {
        $html = "<p>". __('your_verification_code_is') .": <strong>{$code}</strong></p>";
        $alt = __('your_verification_code_is'). ": {$code}";
        
        $mailer = new self();
        return $mailer->to($email)
        ->subject(__('verification_code_2fa'))
        ->body($html, $alt)
        ->send();
    }
    
    public static function sendActivationEmail(string $email, string $token): bool
    {
        $link = env('APP_URL') . "/activate/$token";
        
        $subject = __('activate_your_account');
        $html = "<p>" . __('hi') . ",</p>
             <p>" . __('thanks_for_registering_click_to_activate') . "</p>
             <p><a href=\"" . htmlspecialchars($link, ENT_QUOTES, 'UTF-8') . "\">$link</a></p>
             <p>" . __('ignore_if_not_registered') . "</p>";
        
        $mailer = new self();
        return $mailer
        ->to($email)
        ->subject($subject)
        ->body($html)
        ->send();
    }
    
}