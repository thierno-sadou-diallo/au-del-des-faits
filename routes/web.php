<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentModerationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\CommentController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsletterController;
use App\Http\Controllers\Frontend\PortfolioController;
use App\Http\Controllers\ProfileController;
use App\Models\Portfolio;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/a-propos', [HomeController::class, 'about'])->name('about');
Route::get('/thematiques', [HomeController::class, 'thematiques'])->name('thematiques');
Route::get('/medias', [HomeController::class, 'medias'])->name('medias');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'storeContact'])->name('contact.store');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}/translate', [BlogController::class, 'translate'])->name('blog.translate');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::post('/blog/{post}/comments', [CommentController::class, 'store'])->name('blog.comments.store');
Route::post('/blog/{post}/like', [BlogController::class, 'like'])->name('blog.like');

Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::post('/portfolio/{portfolio}/like', [PortfolioController::class, 'like'])->name('portfolio.like');
Route::post('/portfolio/{portfolio}/comments', [CommentController::class, 'storePortfolioComment'])->name('portfolio.comments.store');
Route::get('/portfolio/{portfolio:slug}', [PortfolioController::class, 'show'])->name('portfolio.show');

Route::get('/refresh-captcha', fn () => response()->json(['captcha' => captcha_img()]))->name('captcha.refresh');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'store'])->name('newsletter.subscribe');

Route::get('/robots.txt', function () {
    return response("User-agent: *\nAllow: /\nSitemap: ".url('/sitemap.xml')."\n", 200)
        ->header('Content-Type', 'text/plain');
});

Route::get('/sitemap.xml', function () {
    $sitemap = Sitemap::create()
        ->add(Url::create(route('home'))->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
        ->add(Url::create(route('about'))->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
        ->add(Url::create(route('thematiques'))->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
        ->add(Url::create(route('medias'))->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
        ->add(Url::create(route('services'))->setPriority(0.6)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
        ->add(Url::create(route('contact'))->setPriority(0.5)->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY))
        ->add(Url::create(route('blog.index'))->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
        ->add(Url::create(route('portfolio.index'))->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));

    foreach (Post::query()->where('status', 'published')->get() as $post) {
        $sitemap->add(
            Url::create(route('blog.show', $post->slug))
                ->setLastModificationDate($post->updated_at)
                ->setPriority(0.7)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        );
    }

    foreach (Portfolio::all() as $project) {
        $sitemap->add(
            Url::create(route('portfolio.show', $project->slug))
                ->setLastModificationDate($project->updated_at)
                ->setPriority(0.6)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        );
    }

    return $sitemap->toResponse(request());
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/posts/ai-draft', [PostController::class, 'aiDraft'])->name('posts.ai-draft');
    Route::resource('posts', PostController::class)->except('show');
    Route::resource('categories', CategoryController::class)->except(['create', 'show', 'edit']);
    Route::resource('portfolios', AdminPortfolioController::class)->except('show');
    Route::get('/comments', [CommentModerationController::class, 'index'])->name('comments.index');
    Route::patch('/comments/{comment}/approve', [CommentModerationController::class, 'approve'])->name('comments.approve');
    Route::post('/comments/{comment}/reply', [CommentModerationController::class, 'reply'])->name('comments.reply');
    Route::delete('/comments/{comment}', [CommentModerationController::class, 'destroy'])->name('comments.destroy');
});

require __DIR__.'/auth.php';
