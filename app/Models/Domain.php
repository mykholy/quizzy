<?php

namespace App\Models;

use App\Traits\IsActiveScope;
use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
class Domain extends Model
{
    use HasFactory;

    public $table = 'domains';

    public $fillable = [
        'username',
        'url',
        'meta',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];


}
