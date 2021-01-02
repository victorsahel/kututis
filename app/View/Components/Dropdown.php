<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Dropdown extends Component
{
    public $required;
    public $value;
    public $name;

    /**
     * Create a new component instance.
     *
     * @param string $name
     * @param $value
     * @param bool $required
     */
    public function __construct(string $name, $value, $required = false)
    {
        $this->name = $name;
        $this->value = $value;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.dropdown');
    }
}
