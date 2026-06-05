<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\Song;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with([
                'userCount' => User::count(),
                'songCount' => Song::count(),
            ]);
        });
    }
}