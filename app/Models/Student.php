<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'age',
        'phone',
        'gender',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];


    public function messages()
    {
        return $this->hasMany(Message::class, 'student_id');
    }

        // علاقة مع طلبات المنح الدراسية (One-to-Many)
        public function requestScholarships()
        {
            return $this->hasMany(RequestScholarship::class, 'student_id');
        }
}