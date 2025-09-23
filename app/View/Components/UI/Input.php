<?php

namespace App\View\Components\UI;

use Illuminate\View\Component;

class Input extends Component
{
    public $type;
    public $name;
    public $label;
    public $placeholder;
    public $value;
    public $required;
    public $class;

    public function __construct($type = 'text', $name = '', $label = '', $placeholder = '', $value = '', $required = false, $class = '')
    {
        $this->type = $type;
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->required = $required;
        $this->class = $class;
    }

    public function render()
    {
        return view('components.ui.input');
    }
}






