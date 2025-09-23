<?php

namespace App\View\Components\UI;

use Illuminate\View\Component;

class Button extends Component
{
    public $type;
    public $variant;
    public $size;
    public $disabled;
    public $class;

    public function __construct($type = 'button', $variant = 'primary', $size = 'md', $disabled = false, $class = '')
    {
        $this->type = $type;
        $this->variant = $variant;
        $this->size = $size;
        $this->disabled = $disabled;
        $this->class = $class;
    }

    public function render()
    {
        return view('components.ui.button');
    }
}






