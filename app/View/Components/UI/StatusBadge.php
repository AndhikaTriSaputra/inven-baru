<?php

namespace App\View\Components\UI;

use Illuminate\View\Component;

class StatusBadge extends Component
{
    public $color;
    public $class;

    public function __construct($color = 'gray', $class = '')
    {
        $this->color = $color;
        $this->class = $class;
    }

    public function render()
    {
        return view('components.ui.status-badge');
    }
}






