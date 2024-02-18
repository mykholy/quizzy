<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
class Coupon extends Model
{
    use HasFactory;
    public $table = 'coupons';

    public $fillable = [
        'title',
        'code',
        'value',
        'student_id',
        'is_active'
    ];

    protected $casts = [
        'title' => 'string',
        'code' => 'string',
        'value' => 'string',
        'is_active' => 'boolean'
    ];

    public static array $rules = [
        'title' => 'nullable',
        'code' => 'nullable',
        'value' => 'nullable'
    ];

    public function student(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin\Student::class, 'student_id', 'id');
    }
}
