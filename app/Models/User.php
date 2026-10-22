<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password', 'status', 'country_code', 'area_code', 'phone'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * Get the user's first name and first last name (primer nombre y primer apellido).
     */
    public function getShortNameAttribute(): string
    {
        $parts = array_values(array_filter(explode(' ', trim($this->name ?? ''))));
        $count = count($parts);

        if ($count === 0) {
            return '';
        }

        if ($count === 1) {
            return $parts[0];
        }

        if ($count >= 4) {
            return "{$parts[0]} {$parts[2]}";
        }

        return "{$parts[0]} {$parts[1]}";
    }

    /**
     * Get initials based on short name (primer nombre y primer apellido).
     */
    public function getInitialsAttribute(): string
    {
        $parts = array_values(array_filter(explode(' ', trim($this->short_name))));

        if (empty($parts)) {
            return 'U';
        }

        if (count($parts) === 1) {
            return mb_strtoupper(mb_substr($parts[0], 0, 2));
        }

        return mb_strtoupper(mb_substr($parts[0], 0, 1) . mb_substr($parts[1], 0, 1));
    }

    /**
     * Get the formatted full phone number.
     */
    public function getFullPhoneAttribute(): string
    {
        if ($this->country_code || $this->area_code || $this->phone) {
            return trim("{$this->country_code} {$this->area_code} {$this->phone}");
        }
        return 'No registrado';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
