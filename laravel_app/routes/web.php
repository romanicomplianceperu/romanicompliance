<?php

use App\Http\Controllers\Admin\AdministratorController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CertificateController as AdminCertificateController;
use App\Http\Controllers\Admin\CompanyController as AdminCompanyController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ExamController as AdminExamController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\ProjectCertificateController as AdminProjectCertificateController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ProjectParticipantController as AdminProjectParticipantController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\StudentAuthController;
use App\Http\Controllers\Admin\CourseQuestionController as AdminCourseQuestionController;
use App\Http\Controllers\Blog\ArticleController as BlogArticleController;
use App\Http\Controllers\CertificateVerificationController;
use App\Http\Controllers\ClaimAccountController;
use App\Http\Controllers\CourseQuestionController;
use App\Http\Controllers\GuestEnrollController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\Learning\CatalogController;
use App\Http\Controllers\Learning\CertificateController as LearningCertificateController;
use App\Http\Controllers\Learning\CourseController as LearningCourseController;
use App\Http\Controllers\Learning\ExamController as LearningExamController;
use App\Http\Controllers\Learning\LessonController as LearningLessonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/capacitaciones', 'capacitaciones')->name('capacitaciones');
Route::get('/equipo', [TeamController::class, 'index'])->name('equipo');

Route::view('/login', 'auth.login')->name('login')->middleware('guest');
Route::post('/login', [StudentAuthController::class, 'authenticate'])->name('login.attempt')->middleware('guest');
Route::get('/registro', [StudentAuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/registro', [StudentAuthController::class, 'register'])->name('register.store')->middleware('guest');
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect')->middleware('guest');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback')->middleware('guest');

Route::get('/admin/login', [AdminAuthController::class, 'show'])->name('admin.login')->middleware('guest');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.attempt')->middleware('guest');

Route::get('/verificar', [CertificateVerificationController::class, 'index'])->name('certificates.verify.form');
Route::get('/verificar/{code}', [CertificateVerificationController::class, 'show'])->name('certificates.verify');

Route::get('/cursos', [CatalogController::class, 'index'])->name('courses.catalog');
Route::get('/cursos/{course:slug}', [LearningCourseController::class, 'show'])->name('courses.show');
Route::post('/cursos/{course:slug}/inicio-rapido', [GuestEnrollController::class, 'start'])->name('courses.guest-start');

Route::get('/proyectos/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/blog', [BlogArticleController::class, 'index'])->name('blog.index');
Route::get('/blog/autor/{user}', [BlogArticleController::class, 'author'])->name('blog.author');
Route::get('/blog/{article:slug}', [BlogArticleController::class, 'show'])->name('blog.show');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/panel', [PanelController::class, 'courses'])->name('dashboard');
    Route::get('/panel/certificados', [PanelController::class, 'certificates'])->name('panel.certificates');
    Route::get('/panel/calendario', [PanelController::class, 'calendar'])->name('panel.calendar');
    Route::get('/panel/perfil', [PanelController::class, 'profile'])->name('panel.profile');
    Route::post('/panel/perfil', [PanelController::class, 'updateProfile'])->name('panel.profile.update');

    Route::get('/completar-perfil', [ProfileController::class, 'edit'])->name('profile.complete');
    Route::post('/completar-perfil', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/cursos/{course:slug}/inscribirse', [LearningCourseController::class, 'enroll'])->name('courses.enroll');
    Route::post('/cursos/{course:slug}/certificacion/pago-reclamado', [LearningCourseController::class, 'claimPayment'])->name('courses.claim-payment');

    Route::get('/lecciones/{lesson}', [LearningLessonController::class, 'show'])->name('lessons.show');
    Route::post('/lecciones/{lesson}/completar', [LearningLessonController::class, 'complete'])->name('lessons.complete');

    Route::get('/cursos/{course:slug}/examen', [LearningExamController::class, 'show'])->name('exams.show');
    Route::post('/cursos/{course:slug}/examen/comenzar', [LearningExamController::class, 'start'])->name('exams.start');
    Route::get('/intentos/{attempt}', [LearningExamController::class, 'take'])->name('exams.take');
    Route::post('/intentos/{attempt}', [LearningExamController::class, 'submit'])->name('exams.submit');
    Route::get('/intentos/{attempt}/resultado', [LearningExamController::class, 'result'])->name('exams.result');

    Route::get('/certificados/{certificate}/descargar', [LearningCertificateController::class, 'download'])->name('certificates.download');

    Route::get('/panel/preguntas', [CourseQuestionController::class, 'index'])->name('panel.questions.index');
    Route::post('/panel/preguntas', [CourseQuestionController::class, 'store'])->name('panel.questions.store');

    Route::get('/crear-cuenta', [ClaimAccountController::class, 'show'])->name('claim-account.show');
    Route::post('/crear-cuenta', [ClaimAccountController::class, 'store'])->name('claim-account.store');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('courses', CourseController::class)->except(['show']);
    Route::post('/courses/{course}/modules', [ModuleController::class, 'store'])->name('modules.store');
    Route::put('/modules/{module}', [ModuleController::class, 'update'])->name('modules.update');
    Route::delete('/modules/{module}', [ModuleController::class, 'destroy'])->name('modules.destroy');
    Route::post('/modules/{module}/lessons', [LessonController::class, 'store'])->name('lessons.store');
    Route::put('/lessons/{lesson}', [LessonController::class, 'update'])->name('lessons.update');
    Route::delete('/lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');

    Route::post('/courses/{course}/exam', [AdminExamController::class, 'store'])->name('exams.store');
    Route::post('/exams/{exam}/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');

    Route::get('/usuarios', [AdminUserController::class, 'index'])->name('users.index');

    Route::get('/certificados', [AdminCertificateController::class, 'index'])->name('certificates.index');
    Route::post('/certificados/{certificate}/revocar', [AdminCertificateController::class, 'revoke'])->name('certificates.revoke');
    Route::post('/certificados/{certificate}/reemitir', [AdminCertificateController::class, 'reissue'])->name('certificates.reissue');
    Route::post('/certificados/pendientes/{enrollment}/emitir', [AdminCertificateController::class, 'issuePending'])->name('certificates.issue-pending');

    Route::resource('empresas', AdminCompanyController::class)->except(['show'])->parameters(['empresas' => 'company']);

    Route::resource('proyectos', AdminProjectController::class)->parameters(['proyectos' => 'project']);
    Route::post('/proyectos/{project}/participantes', [AdminProjectParticipantController::class, 'store'])->name('projects.participants.store');
    Route::delete('/proyectos/{project}/participantes/{participant}', [AdminProjectParticipantController::class, 'destroy'])->name('projects.participants.destroy');
    Route::post('/proyectos/{project}/certificados', [AdminProjectCertificateController::class, 'store'])->name('projects.certificates.store');

    Route::resource('articulos', AdminArticleController::class)->except(['show'])->parameters(['articulos' => 'article']);

    Route::resource('administradores', AdministratorController::class)->only(['index', 'create', 'store', 'destroy'])->parameters(['administradores' => 'administrator']);

    Route::get('/personalizacion', [SiteSettingController::class, 'index'])->name('settings.index');
    Route::put('/personalizacion', [SiteSettingController::class, 'update'])->name('settings.update');

    Route::get('/preguntas-alumnos', [AdminCourseQuestionController::class, 'index'])->name('questions-support.index');
    Route::post('/preguntas-alumnos/{question}/responder', [AdminCourseQuestionController::class, 'answer'])->name('questions-support.answer');
});
