<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
