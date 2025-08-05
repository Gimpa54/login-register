<?php
namespace App\Models;

use App\Core\BaseModel;

class Passwordreset extends BaseModel
{
    protected $table = 'password_resets';

    public function createOrUpdate(string $email, string $token): bool
    {
        $data = [
            'email' => $email,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s'),
            'expires_at' => date('Y-m-d H:i:s', strtotime('+1 hour'))
        ];

        return $this->findBy('email', $email)
            ? $this->updateBy('email', $email, $data)
            : $this->create($data);
    }

    public function isValid(string $token): bool
    {
        $reset = $this->findBy('token', $token);
        return $reset && $reset->expires_at > date('Y-m-d H:i:s');
    }

    public function getEmailByToken(string $token): ?string
    {
        $reset = $this->findBy('token', $token);
        return $reset?->email;
    }

    public function delete(string $token): bool
    {
        return $this->deleteBy('token', $token);
    }
}
