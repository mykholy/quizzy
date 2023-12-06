<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    const UPDATED_AT = null;
    protected $fillable = [
        'email', 'token',
    ];
}
