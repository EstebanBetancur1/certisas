<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);                             //:end-bindings:
        $this->app->bind(\App\Repositories\SettingRepository::class, \App\Repositories\SettingRepositoryEloquent::class);                       //:end-bindings:
        $this->app->bind(\App\Repositories\LanguageRepository::class, \App\Repositories\LanguageRepositoryEloquent::class);                     //:end-bindings:
        $this->app->bind(\App\Repositories\PostRepository::class, \App\Repositories\PostRepositoryEloquent::class);                             //:end-bindings:
        $this->app->bind(\App\Repositories\PostTranslationRepository::class, \App\Repositories\PostTranslationRepositoryEloquent::class);       //:end-bindings:
        $this->app->bind(\App\Repositories\BlockRepository::class, \App\Repositories\BlockRepositoryEloquent::class);                           //:end-bindings:
        $this->app->bind(\App\Repositories\BlockTranslationRepository::class, \App\Repositories\BlockTranslationRepositoryEloquent::class);     //:end-bindings:
        $this->app->bind(\App\Repositories\RequestRepository::class, \App\Repositories\RequestRepositoryEloquent::class);     //:end-bindings:
        
        $this->app->bind(\App\Repositories\CompanyRepository::class, \App\Repositories\CompanyRepositoryEloquent::class);     //:end-bindings:
        $this->app->bind(\App\Repositories\CompanyUserRepository::class, \App\Repositories\CompanyUserRepositoryEloquent::class);     //:end-bindings:
        
        $this->app->bind(\App\Repositories\ActivityRepository::class, \App\Repositories\ActivityRepositoryEloquent::class);     //:end-bindings:
        $this->app->bind(\App\Repositories\ResponsibilityRepository::class, \App\Repositories\ResponsibilityRepositoryEloquent::class);     //:end-bindings:

        $this->app->bind(\App\Repositories\CompanyActivityRepository::class, \App\Repositories\CompanyActivityRepositoryEloquent::class);     //:end-bindings:
        $this->app->bind(\App\Repositories\CompanyResponsibilityRepository::class, \App\Repositories\CompanyResponsibilityRepositoryEloquent::class);     //:end-bindings:
        
        $this->app->bind(\App\Repositories\TemplateRepository::class, \App\Repositories\TemplateRepositoryEloquent::class);     //:end-bindings:
        $this->app->bind(\App\Repositories\TemplateItemRepository::class, \App\Repositories\TemplateItemRepositoryEloquent::class);     //:end-bindings:
        
        $this->app->bind(\App\Repositories\StateRepository::class, \App\Repositories\StateRepositoryEloquent::class);     //:end-bindings:
        $this->app->bind(\App\Repositories\CityRepository::class, \App\Repositories\CityRepositoryEloquent::class);     //:end-bindings:
        $this->app->bind(\App\Repositories\SectionalRepository::class, \App\Repositories\SectionalRepositoryEloquent::class);     //:end-bindings:
        
        $this->app->bind(\App\Repositories\EmissionRepository::class, \App\Repositories\EmissionRepositoryEloquent::class);     //:end-bindings:
        $this->app->bind(\App\Repositories\BankRepository::class, \App\Repositories\BankRepositoryEloquent::class);     //:end-bindings:
        
        $this->app->bind(\App\Repositories\DeclarationRepository::class, \App\Repositories\DeclarationRepositoryEloquent::class);     //:end-bindings:
        $this->app->bind(\App\Repositories\MunicipalityRepository::class, \App\Repositories\MunicipalityRepositoryEloquent::class);     //:end-bindings:

        $this->app->bind(\App\Repositories\TicketRepository::class, \App\Repositories\TicketRepositoryEloquent::class);     //:end-bindings:
        $this->app->bind(\App\Repositories\MessageRepository::class, \App\Repositories\MessageRepositoryEloquent::class);     //:end-bindings:
    }
}