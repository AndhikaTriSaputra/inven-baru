<?php

namespace App\Providers;

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
        // Register UI components namespace
        $this->loadViewComponentsAs('ui', [
            'button' => \App\View\Components\UI\Button::class,
            'input' => \App\View\Components\UI\Input::class,
            'table' => \App\View\Components\UI\Table::class,
            'card' => \App\View\Components\UI\Card::class,
            'modal' => \App\View\Components\UI\Modal::class,
            'page-header' => \App\View\Components\UI\PageHeader::class,
            'search-input' => \App\View\Components\UI\SearchInput::class,
            'action-buttons' => \App\View\Components\UI\ActionButtons::class,
            'status-badge' => \App\View\Components\UI\StatusBadge::class,
            'alert' => \App\View\Components\UI\Alert::class,
        ]);
    }
}
