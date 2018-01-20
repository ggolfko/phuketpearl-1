<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
		'App\Http\Middleware\CloudFlareProxies',
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
        ],

        'api' => [
            'throttle:60,1',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
		'dashboard.auth' => \App\Http\Middleware\DashboardAuthenticate::class,
		'dashboard.guest' => \App\Http\Middleware\DashboardRedirectIfAuthenticated::class,
		'permission.setting' => \App\Http\Middleware\Permission\Setting::class,
		'permission.employee' => \App\Http\Middleware\Permission\Employee::class,
        'permission.product' => \App\Http\Middleware\Permission\Product::class,
        'permission.newsletter' => \App\Http\Middleware\Permission\Newsletter::class,
        'permission.news' => \App\Http\Middleware\Permission\News::class,
        'permission.contact' => \App\Http\Middleware\Permission\Contact::class,
        'permission.gallery' => \App\Http\Middleware\Permission\Gallery::class,
        'permission.video' => \App\Http\Middleware\Permission\Video::class,
        'permission.document' => \App\Http\Middleware\Permission\Document::class,
        'permission.tour' => \App\Http\Middleware\Permission\Tour::class,
        'permission.book' => \App\Http\Middleware\Permission\Book::class,
        'permission.payment' => \App\Http\Middleware\Permission\Payment::class,
        'permission.enquiry' => \App\Http\Middleware\Permission\Enquiry::class
    ];
}
