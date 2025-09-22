<?php

namespace App\View\Components\UI;

use Illuminate\View\Component;

class ActionButtons extends Component
{
    public $view;
    public $edit;
    public $delete;
    public $class;

    public function __construct($view = '', $edit = '', $delete = '', $class = '')
    {
        $this->view = $view;
        $this->edit = $edit;
        $this->delete = $delete;
        $this->class = $class;
    }

    public function render()
    {
        return view('components.ui.action-buttons');
    }
}



