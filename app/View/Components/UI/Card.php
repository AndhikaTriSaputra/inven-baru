<?php

namespace App\View\Components\UI;

use Illuminate\View\Component;

class Card extends Component
{
    public $class;

    public function __construct($class = '')
    {
        $this->class = $class;
    }

    public function render()
    {
        return view('components.ui.card');
    }
}






