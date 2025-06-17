<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    //
    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'comments','reply','is_reply'];
}
