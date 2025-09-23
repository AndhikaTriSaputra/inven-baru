<?php

namespace App\View\Components\UI;

use Illuminate\View\Component;

class Modal extends Component
{
    public $id;
    public $title;
    public $size;
    public $class;

    public function __construct($id = '', $title = '', $size = 'md', $class = '')
    {
        $this->id = $id;
        $this->title = $title;
        $this->size = $size;
        $this->class = $class;
    }

    public function render()
    {
        return view('components.ui.modal');
    }
}






