<?php

namespace App\View\Components\UI;

use Illuminate\View\Component;

class SearchInput extends Component
{
    public $id;
    public $placeholder;
    public $class;

    public function __construct($id = 'search', $placeholder = 'Search...', $class = '')
    {
        $this->id = $id;
        $this->placeholder = $placeholder;
        $this->class = $class;
    }

    public function render()
    {
        return view('components.ui.search-input');
    }
}






