<?php

namespace App\Providers;

use App\Repositories\BoardRepository;
use App\Repositories\BrandRepository;
use App\Repositories\CardRepository;
use App\Repositories\Contracts\BoardRepositoryInterface;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Contracts\CardRepositoryInterface;
use App\Repositories\Contracts\OptionRepositoryInterface;
use App\Repositories\Contracts\OptionValueDescriptionRepositoryInterface;
use App\Repositories\Contracts\ProductOptionRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use App\Repositories\OptionRepository;
use App\Repositories\OptionValueDescriptionRepository;
use App\Repositories\ProductOptionRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProjectRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
        $this->app->bind(OptionRepositoryInterface::class, OptionRepository::class);
        $this->app->bind(OptionValueDescriptionRepositoryInterface::class, OptionValueDescriptionRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductOptionRepositoryInterface::class, ProductOptionRepository::class);
        $this->app->bind(BoardRepositoryInterface::class, BoardRepository::class);
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(CardRepositoryInterface::class, CardRepository::class);
    }
}
