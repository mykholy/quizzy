<?php

namespace App\Models\Admin;

use App\Traits\InvitationTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Musonza\Chat\Traits\Messageable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Student extends  Authenticatable  implements JWTSubject , MustVerifyEmail
{
    use HasFactory;
    use Messageable;
    use Notifiable;
    use InvitationTrait;

    public $table = 'students';

    public $fillable = [
        'name',
        'username',
        'location_area',
        'email',
        'phone',
        'password',
        'photo',
        'provider_id',
        'provider_type',
        'governorate',
        'area',
        'residence_area',
        'specialization',
        'academic_year_id',
        'date_of_birth',
        'device_token',
        'phone_verified',
        'balance',
        'invitation_code',
        'invited_by',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'password' => 'string',
        'photo' => 'string',
        'provider_id' => 'string',
        'provider_type' => 'string',
        'device_token' => 'string',
        'balance' => 'integer',
        'is_active' => 'boolean',
        'phone_verified' => 'boolean'
    ];

    public static array $rules = [
        'name' => 'required|min:3|max:100',
        'email' => 'nullable|email|min:3|max:255|unique:students',
        'phone' => 'nullable|min:6|max:20|unique:students',
        'password' => 'required_without:id|nullable|min:6',
        'photo' => 'required_without:id'
    ];

    public function getPhotoAttribute($value)
    {
        return $value ? asset($value) : null;
    }
    public function academicYear(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin\AcademicYear::class, 'academic_year_id', 'id');
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public const governoratListGaza = [
        "شمال غزة",
        "غزة",
        "دير البلح",
        "خان يونس",
        "رفح"
    ];
    public const governorateListWest = [
        "القدس",
        "بيت لحم",
        "الخليل",
        'رام الله البيرة',
        'نابلس',
        'سلفيت',
        'قلقيلية',
        "طولكرم",
        "طوباس",
        "جنين",
        "أريحا"
    ];
    public const getAreaName = [
        "القدس" => [
            "أبو ديس",
            "أم طوبا",
            "الحي الإسلامي",
            " بيت إجزا",
            "بيت إكسا",
            'السواحرة الغربية',
            'أم طوبا',
            'الشيخ جراح',
            'القسطل',
            'المستعمرة األمريكية',
            'بيت عنان',
            'بيت محسير',
            'الجديرة',
            'الجيب',
            'الرام',
            'راس أبوعمار',
            'راس العامود',
            'بيت دقو',
            ' بيت سوريك',
            'الشيخ سعد',
            'العيزرية',
            'حاجز قلنديا',
            'حارة النصارى',
            'حزما',
            'رافات',
            'بيت جمال',
            'بيت حنينا',
            'سلوان',
            'صور باهر',
            'شرفات',
            'شعفاط',
            'بدو',
            'بيت صفافا',
            'بيت نقوبا',
            'جبع',
            'جبل المكبر',
            'عين رافة',
            'عين نقوبا',
            'عناتا',
            'العيسوية',
            'السواحرة الشرقية',
            'كفر عقب',
            'عين حيمد',
            'الطور',
            'علار',
            'لفتا',
            'القدس الشرقية',
            'قطنة',
            'قلنديا',
            'مخماس',
            'مخيم شعفاط',
            'قالونيا',
            'القبيبة',
        ],
        "بيت لحم" => [
            'بيت لحم:',
            'بيت جالا',
            'بيت ساحور',
            'بتير',
            'بيت تعمر',
            'بيت فجار',
            'جبة الذيب',
            'الجبعة',
            'جهاثم',
            'جورة الشمعة',
            "الحجيلة",
            "الحدايدة",
            "الحلقوم",
            'حوسان',
            'خربة الدير',
            'خربة النخلة',
            'خربة تقوع',
            'الخضر',
            'رخمة',
            'الشواورة',
            'ظهرة الندى',
            'العبيدية',
            'عرب الرشايدة',
            'العساكرة',
            'القبو',
            'كفار عصيون',
            'نحالين',
            'مراح رباح',
            'مراح معلا',
            'وادي العرايس',
            'وادي النيص',
            'وادي رحال',
            'وادي فوكين',
            'الولجة',
            'أم سلمونة',
            'الدوحة',
            'المعصرة',
            'المنشية',
        ],
        "الخليل" => [
            // Add areas for Al Khalil governorate here
        ],
        "رام الله البيرة" => [
            // Add areas for Ramallah & Al Bireh governorate here
        ],
        "نابلس" => [
            // Add areas for Nablus governorate here
        ],
        "سلفيت" => [
            // Add areas for Salfit governorate here
        ],
        "قلقيلية" => [
            // Add areas for Qalqilya governorate here
        ],
        "طولكرم" => [
            // Add areas for Tulkarm governorate here
        ],
        "طوباس" => [
            // Add areas for Tubas governorate here
        ],
        "جنين" => [
            // Add areas for Jenin governorate here
        ],
        "أريحا" => [
            // Add areas for Jericho governorate here
        ],
        // Add areas for other governorates here
    ];

    public const stateOfAreaList = ["مخيم", "قرية", "مدينة"];

}
