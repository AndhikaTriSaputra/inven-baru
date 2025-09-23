<?php

namespace App\View\Components\UI;

use Illuminate\View\Component;

class PageHeader extends Component
{
    public $title;
    public $breadcrumb;
    public $actions;

    public function __construct($title = '', $breadcrumb = '', $actions = '')
    {
        $this->title = $title;
        $this->breadcrumb = $breadcrumb;
        $this->actions = $actions;
    }

    public function render()
    {
        return view('components.ui.page-header');
    }
}






