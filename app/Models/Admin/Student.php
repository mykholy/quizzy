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

class Student extends Authenticatable implements JWTSubject, MustVerifyEmail
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
        'username' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'password' => 'string',
        'photo' => 'string',
        'provider_id' => 'string',
        'provider_type' => 'string',
        'device_token' => 'string',
        'balance' => 'integer',
        'is_active' => 'boolean',
        'phone_verified' => 'boolean',
        'location_area'=>'string',
        'governorate'=>'string',
        'area'=>'string',
        'residence_area' =>'string',
        'specialization'=>'string',
        'academic_year_id'=>'integer',
        'date_of_birth'=>'string',
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
            "السواحرة الغربية",
            "أم طوبا",
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
            'أم برج',
            'بركوسيا',
            'بيت أولا',
            'بيت الروش الفوقا',
            'الدوايمة',
            'الرماضين',
            'بيت جبرين',
            'بيت عمرة',
            'بيت عوا',
            'الصرة',
            'الظاهرية',
            'التواني',
            'امريش',
            'بيت مرسم',
            'بيت نتيف',
            'العديسة',
            'الشيوخ',
            'حدب الفوار',
            'حلحول',
            'تفوح',
            'تل الصافي',
            'الكوم',
            'دير الدبان',
            'دير العسل',
            'الفوقا',
            'دير رازح',
            'جالا',
            'خربة عتير',
            'خرسا',
            'دير نخاس',
            'سنجر',
            'طرامة',
            'عجور',
            'عناب الكبير',
            'رابود',
            'رعنا',
            'زكريا',
            'رافات',
            'جبعة',
            'زيف',
            'الجبلية',
            'كويزبة',
            'وادي الشاجنة',
            'يطا، كدنة',
            'كرمة'
        ],
        'رام الله البيرة' => [
            'اللبن الغربي',
            'المزرعة الشرقية',
            'أبو شخيدم',
            'أبو قش',
            'بلعين',
            'بيت إللو',
            'بيت ريما',
            'الجانية',
            'الطيبة',
            'المزرعة القبلية',
            'أبوشخيدم',
            'بيت سيرا',
            'بيت عور التحتا',
            'بدرس',
            'برقة',
            'جفنا',
            'جلجيليا',
            'بيت عور الفوقا',
            'بيت لقيا',
            'جمالا',
            'جيبيا',
            'ترمسعيا',
            'بيتين',
            'بيرزيت',
            'خربة أبو فلاح',
            'خربتا المصباح',
            'دير نضام',
            'دير نظام',
            'سردا',
            'سلواد',
            'رمون',
            'رنتيس',
            'دورا القرع',
            'دير أبو مشعل',
            'دير إبزيع',
            'دير السودان',
            'شبتين',
            'شقبا',
            'رأس كركر',
            'طيرة',
            'صفا',
            'سنجل',
            'عين سينيا',
            'عين عريك',
            'عين قينيا',
            'دير دبوان',
            'دير عمار',
            'دير غسانة',
            'دير قديس',
            'عجول',
            'عطارة',
            'كفر عين',
            'كفر مالك',
            'كوبر',
            'عابود',
            'عارورة',
            'عبوين',
            'عين يبرود',
            'قبية',
            'قراوة بني زيد',
            'نعلين',
            'يبرود رام الله',
        ],
        "نابلس" => [
            'برقة',
            'بالطة البلد',
            'إجنسنيا',
            'اللبن الشرقية',
            'بيت دجن',
            'بيت امرين',
            'بزاريا',
            'بورين',
            'جالود',
            'جبل باي يزيد',
            'تل',
            'تلفيت',
            'بتما',
            'بيت',
            'فوريك',
            'بيت زن',
            'بيتا',
            'رامين',
            'دير الحطب',
            'دير شرف',
            'جماعين',
            'جوريش',
            'حوارة، حجة',
            'دوما',
            'الساوية',
            'سبسطية',
            'زواتا',
            'زيتا جماعين',
            'قصرة',
            'العقربانية',
            'عورتا',
            'سبسطية الجديدة',
            'سالم',
            'صرة',
            'مادما',
            'مجدل بني فاضل',
            'عصيرة الشمالية',
            'عصيرة القبلية',
            'عزموط',
            'عسكر البلد',
            'الناقورة الجنوبية',
            'نص اجبيل',
            'نص جبيل',
            'عوريف',
            'كفر قليل',
            'عقربا',
            'بيت ايبا',
            'سنيرية',
        ],
        "سلفيت" => [
            'سلفيت',
            'خربة قيس',
            'اسكاكا',
            'ياسوف',
            'مردا',
            'قيرة',
            'كفل حارس',
            'حارس',
            'دير استيا',
            'بديا',
            'الزاوية',
            'قراوة بني حسان',
            'سرطة مسحة',
            'رافات',
            'دير بلوط',
            'كفر الديك',
            'بروقين',
            'فرخة',
        ],
        "قلقيلية" => [
            'إماتين',
            'عزبة جلعود',
            'جيت',
            'الرماضين الجنوبي',
            'الرماضين الشمالي',
            'باقة الحطب',
            'بيت أمين',
            'راس طيرة',
            'راس عطية',
            'الفندق',
            'جيوس',
            'حبلة',
            'عزبة الطبيب',
            'عزبة سلمان',
            'عزون',
            'فرعتا',
            'فلامية',
            'كفر ثلث',
            'كفر قدوم',
            'عزبة الأشقر',
            'عزون عتمة',
            'عسلة',
            'واد الرشا',
            'المدور',
            'مغارة الضبعة',
            'كفر لاقف',
            'النبي إلياس',
        ],
        "طولكرم" => [
            'أم خالد',
            'باقة الشرقية',
            'بلعا',
            'بيت ليد',
            'ارتاح',
            'النزلة الشرقية',
            'دير الغصون',
            'خربة بيت ليد',
            'سفارين',
            'إكتابا',
            'ذنابة',
            'شويكة',
            'صيدا',
            'زيتا',
            'عتيل',
            'عكابا',
            'عنبتا',
            'شعراوية',
            'شوفة',
            'كفر صور',
            'كفر عبوش',
            'قرية كفر جمال',
            'قفين',
            'كفر رمان',
            'كفر زيباد',
            'نزلة أبو نار',
            'نزلة عيسى',
            'كفر اللبد',
            'كفر جمال',
            'وادي الشعير',
        ],
        "طوباس" => [
            'طوباس',
            'عقابا',
            'طمون',
            'بردلا',
            'عين البيضة',
            'كردلا',
            'راس الفارعة',
            'تياسير',
            'وادي الفارعة',
            'مخيم الفارعة',
        ],
        "جنين" => [
            'أم التوت',
            'أم الريحان',
            'أم دار',
            'الزبابدة',
            'السيلة الحارثية',
            'المغير',
            'اليامون',
            'البارد الهاشمية',
            'الخلجان',
            'ألمانية',
            'الفندقومية',
            'الكفير',
            'اللجون',
            'العطارة',
            'العقبة',
            'المزار',
            'جلقموس',
            'جلمة',
            'بيت قاد',
            'بير الباشا',
            'عين المنسي',
            'تعنك',
            'تلفيت',
            'جربا',
            'جلبون',
            'برطعة',
            'برقين',
            'خربة',
            'الجوفة',
            'جنزور',
            'جبل حريش',
            'جديدة',
            'جبع',
            'دير أبو ضعيف',
            'دير غزالة',
            'خربة عبد الله اليونس',
            'خربة نزلة زيد',
            'خربة طورة الغربية',
            'رابا',
            'الرامة',
            'خربة المطلة',
            'صير',
            'طورة الشرقية',
            'زرعين',
            'رمانة',
            'زبدة',
            'صانور',
            'طيبة',
            'عابا',
            'عانين',
            'عجة',
            'عرانة',
            'عربونة',
            'فحمة',
            'عنزة',
            'عطارة',
            'عرابة',
            'عرقة',
            'فقوعة',
            'قباطية',
            'قصر المشاكي',
            'فراسين',
            'مثلث الشهداء',
            'كفير',
            'كفر دان',
            'كفر راعي',
            'كفر قود',
            'منشية',
            'العطارى',
            'نزلة الشيخ زيد',
            'كفيرت',
            'هاشمية',
            'مسلية',
        ],
        'أريحا' => [
            'أريحا',
            'العوجا',
            'النويعمة',
            'ديوك',
            'فصايل',
            'الجفتلك',
            'الزبيدات',
            'عقبة جبر',
            'عين السلطان',
            'بردلا',
            'مرج الغزال',
            'مرج نعجة',
        ],
        "شمال غزة" => ['ام النصر', 'بيت لاهيا', 'مخيم جباليا', 'جباليا'],
        "غزة" => ['غزة', 'مخيم الشاطئ', 'الزهراء', 'المغرافة', 'جحر الديك'],
        'دير البلح' => [
            'دير البلح',
            'مخيم دير البلح',
            'مخيم النصيرات',
            'النصيرات',
            'البريج',
            'مخيم المغازي',
            'المغازي',
            'الزوايدة',
            'المصدر',
            'وادي السلقا',
        ],
        "خان يونس" => [
            'خان يونس',
            'مخيم خان يونس',
            'بني سهيلا',
            'القرارة',
            'عبسان الجديدة',
            'خزاعة',
            'الفخاري',
        ],
        "رفح" => [
            'رفح',
            'مخيم رفح',
            'النصر',
            'شوكة الصوفي',
        ],
    ];

    public const stateOfAreaList = ["مخيم", "قرية", "مدينة"];

}
