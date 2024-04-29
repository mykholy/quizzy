<?php

namespace App\Models\Admin;

use Carbon\Carbon;
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
        'price',
        'student_id',
        'is_active'
    ];

    protected $casts = [
        'title' => 'string',
        'code' => 'string',
        'price' => 'string',
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

    public function getCreatedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d'): null;
    }
    public function getUpdatedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d'): null;
    }

}
