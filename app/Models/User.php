<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Modèle Utilisateur — représente l'administrateur unique de l'application.
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function booted(): void
    {
        static::deleting(function (self $user) {
            if ($user->isAdminAccount()) {
                throw new \RuntimeException(sprintf(
                    'Le compte administrateur "%s" est protégé et ne peut pas être supprimé.',
                    $user->email ?? static::adminEmail()
                ));
            }
        });
    }

    public static function adminEmail(): string
    {
        return (string) config('admin.email', 'ajudn@gmail.com');
    }

    public static function adminName(): string
    {
        return (string) config('admin.name', 'Administrateur');
    }

    public function isAdminAccount(): bool
    {
        return strtolower((string) ($this->email ?? '')) === strtolower(static::adminEmail());
    }

    public function delete(array $options = [])
    {
        if ($this->isAdminAccount()) {
            throw new \RuntimeException(sprintf(
                'Le compte administrateur "%s" est protégé et ne peut pas être supprimé.',
                $this->email ?? static::adminEmail()
            ));
        }

        return parent::delete($options);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
