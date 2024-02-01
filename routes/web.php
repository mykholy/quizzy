<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();


Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder');

Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template');

Route::get('relation_field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template');

Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate');

Route::post('generator_builder/rollback', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback');

Route::post(
    'generator_builder/generate-from-file',
    '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile'
)->name('io_generator_builder_generate_from_file');

Route::prefix('admin')->name('admin.')->group(function () {

    ###################################### Start  Admin Auth ##########################################
    Route::middleware(['auth'])->group(function () {
        Route::resource('clients', App\Http\Controllers\Admin\ClientController::class);

        Route::resource('cars', App\Http\Controllers\Admin\CarController::class);
        Route::resource('amenities', App\Http\Controllers\Admin\AmenityController::class);
        Route::get('locations/import', [App\Http\Controllers\Admin\LocationController::class,'import_get'])->name('locations.import');
        Route::post('locations/import', [App\Http\Controllers\Admin\LocationController::class,'import'])->name('locations.import');
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
        Route::get('questions/{id}/books', [App\Http\Controllers\Admin\QuestionController::class,'ajax_get_books_by_subject'])->name('questions.ajax_get_units_by_subject');
        Route::get('questions/{id}/units', [App\Http\Controllers\Admin\QuestionController::class,'ajax_get_units_by_book'])->name('questions.ajax_get_units_by_book');
        Route::get('questions/{id}/lessons', [App\Http\Controllers\Admin\QuestionController::class,'ajax_get_lessons_by_unit']);
        Route::resource('questions', App\Http\Controllers\Admin\QuestionController::class);
        Route::resource('answers', App\Http\Controllers\Admin\AnswerController::class);
        Route::resource('ads', App\Http\Controllers\Admin\AdController::class);

        Route::get('settings/general', [App\Http\Controllers\Admin\SettingController::class, 'general'])->name('settings.general');
        Route::post('settings/updateSettings', [App\Http\Controllers\Admin\SettingController::class, 'updateSettings'])->name('settings.updateSettings');

    });
    ###################################### End  Admin Auth ##########################################


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
