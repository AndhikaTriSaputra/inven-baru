<?php

namespace App\View\Components\UI;

use Illuminate\View\Component;

class Alert extends Component
{
    public $type;
    public $class;

    public function __construct($type = 'info', $class = '')
    {
        $this->type = $type;
        $this->class = $class;
    }

    public function render()
    {
        return view('components.ui.alert');
    }
}



