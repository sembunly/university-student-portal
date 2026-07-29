<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentAccount extends Model
{
    protected $fillable = [
        'student_id',
        'phone',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function apiTokens(): HasMany
    {
        return $this->hasMany(StudentApiToken::class);
    }
}
