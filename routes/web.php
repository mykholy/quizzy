<?php

use App\Http\Controllers\Teacher\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/test_text', function () {
    $result = calculateTextSimilarity(
        "The quick brown fox jumps over the lazy dog.",
        "The lazy dog jumps over the quick brown fox."
    );
    dd($result,$result['similarity']);
});
Route::get('/', function () {
    return redirect()->route('home');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/{page}', function ($page) {

    $pages = ['terms', 'privacy_policy'];
    if (!in_array($page, $pages))
        abort(404);


    return view('page', compact('page'));
});

Route::get('/upload-files/coBsIzXSXOaz2Uye8hVlNSkTA1immmfjJ91ml6adYiv104CBrr', function () {


    return view('file_upload');
});

Route::post('/upload-files/store', function (Request $request) {

    if ($request->hasFile('upload_files')) {
        if ($request->upload_files) {
            $files_url_data = [];
            foreach ($request->upload_files as $file) {
                $url_file = uploadImage('uploads', $file);
                $files_url_data[] = asset($url_file);

            }

            return view('file_upload', compact('files_url_data'));

        }
    }
    return back();

})->name('public.upload-files');


Route::prefix('admin')->name('admin.')->group(function () {

    ###################################### Start  Admin Auth ##########################################
    Route::middleware(['auth'])->group(function () {
        Route::resource('clients', App\Http\Controllers\Admin\ClientController::class);

        Route::resource('cars', App\Http\Controllers\Admin\CarController::class);
        Route::resource('amenities', App\Http\Controllers\Admin\AmenityController::class);
        Route::get('locations/import', [App\Http\Controllers\Admin\LocationController::class, 'import_get'])->name('locations.import');
        Route::post('locations/import', [App\Http\Controllers\Admin\LocationController::class, 'import'])->name('locations.import');
        Route::resource('locations', App\Http\Controllers\Admin\LocationController::class);
        Route::resource('connectors', App\Http\Controllers\Admin\ConnectorController::class);
        Route::resource('stations', App\Http\Controllers\Admin\StationController::class);

        Route::resource('teachers', App\Http\Controllers\Admin\TeacherController::class);
        Route::resource('subjects', App\Http\Controllers\Admin\SubjectController::class);
        Route::resource('groups', App\Http\Controllers\Admin\GroupController::class);
        Route::resource('students', App\Http\Controllers\Admin\StudentController::class);
        Route::resource('academicYears', App\Http\Controllers\Admin\AcademicYearController::class);
        Route::resource('units', App\Http\Controllers\Admin\UnitController::class);
        Route::resource('lessons', App\Http\Controllers\Admin\LessonController::class);
        Route::get('questions/{id}/books', [App\Http\Controllers\Admin\QuestionController::class, 'ajax_get_books_by_subject'])->name('questions.ajax_get_units_by_subject');
        Route::get('questions/{id}/units', [App\Http\Controllers\Admin\QuestionController::class, 'ajax_get_units_by_book'])->name('questions.ajax_get_units_by_book');
        Route::get('questions/{id}/lessons', [App\Http\Controllers\Admin\QuestionController::class, 'ajax_get_lessons_by_unit']);
        Route::post('questions/bulk-import', [App\Http\Controllers\Admin\QuestionController::class, 'bulkStore'])->name('questions.bulkImport');
        Route::resource('questions', App\Http\Controllers\Admin\QuestionController::class);
        Route::resource('answers', App\Http\Controllers\Admin\AnswerController::class);
        Route::resource('ads', App\Http\Controllers\Admin\AdController::class);
        Route::resource('coupons', App\Http\Controllers\Admin\CouponController::class);

        Route::get('settings/general', [App\Http\Controllers\Admin\SettingController::class, 'general'])->name('settings.general');
        Route::post('settings/updateSettings', [App\Http\Controllers\Admin\SettingController::class, 'updateSettings'])->name('settings.updateSettings');
        Route::get('notifications', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
        Route::post('notifications/send', [App\Http\Controllers\Admin\NotificationController::class, 'send'])->name('notifications.send');

    });
    ###################################### End  Admin Auth ##########################################


});

Route::prefix('teacher')->name('teacher.')->group(function () {
    // Teacher routes here
    Route::group(['prefix' => 'auth'], function () {

        Route::get('login', [LoginController::class,'getLogin'])->name('get.login');


        Route::post('login', [LoginController::class,'login'])->name('login');

        Route::post('logout', [LoginController::class,'logout'])->name('logout');


    });
    Route::middleware(['auth:teacher'])->group(function () {
        Route::get('/home', [\App\Http\Controllers\Teacher\HomeController::class,'index'])->name('dashboard');
        Route::resource('groups', App\Http\Controllers\Teacher\GroupController::class);

        Route::get('questions/types/get_questions_by_types', [App\Http\Controllers\Teacher\QuestionController::class, 'ajax_get_questions_by_types'])->name('questions.ajax_get_questions_by_types');
        Route::get('questions/{id}/books', [App\Http\Controllers\Teacher\QuestionController::class, 'ajax_get_books_by_subject'])->name('questions.ajax_get_units_by_subject');
        Route::get('questions/{id}/units', [App\Http\Controllers\Teacher\QuestionController::class, 'ajax_get_units_by_book'])->name('questions.ajax_get_units_by_book');
        Route::get('questions/{id}/lessons', [App\Http\Controllers\Teacher\QuestionController::class, 'ajax_get_lessons_by_unit']);
        Route::post('questions/bulk-import', [App\Http\Controllers\Teacher\QuestionController::class, 'bulkStore'])->name('questions.bulkImport');
        Route::resource('questions', App\Http\Controllers\Teacher\QuestionController::class);
        Route::resource('answers', App\Http\Controllers\Teacher\AnswerController::class);
        Route::resource('exams', App\Http\Controllers\Teacher\ExamController::class);


    });



});

Route::resource('admin/books', App\Http\Controllers\Admin\BookController::class)
    ->names([
        'index' => 'admin.books.index',
        'store' => 'admin.books.store',
        'show' => 'admin.books.show',
        'update' => 'admin.books.update',
        'destroy' => 'admin.books.destroy',
        'create' => 'admin.books.create',
        'edit' => 'admin.books.edit'
    ]);

Route::resource('admin/exams', App\Http\Controllers\Admin\ExamController::class)
    ->names([
        'index' => 'admin.exams.index',
        'store' => 'admin.exams.store',
        'show' => 'admin.exams.show',
        'update' => 'admin.exams.update',
        'destroy' => 'admin.exams.destroy',
        'create' => 'admin.exams.create',
        'edit' => 'admin.exams.edit'
    ]);

