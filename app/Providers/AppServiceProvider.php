<?php

namespace App\Providers;

use App\Models\Archive;
use App\Models\Question;
use App\Policies\ArchivePolicy;
use App\Policies\QuestionPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Question::class, QuestionPolicy::class);
        Gate::policy(Archive::class, ArchivePolicy::class);
    }
}
