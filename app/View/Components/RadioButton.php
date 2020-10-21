<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RadioButton extends Component
{
    /**
     * @var string
     */
    public $name;
    public $value;
    public $required;
    public $selected;

    /**
     * Create a new component instance.
     *
     * @param string $name
     * @param $value
     * @param bool $required
     */
    public function __construct(string $name, $value, $selected, $required = false)
    {
        $this->name = $name;
        $this->value = $value;
        $this->required = $required;
        $this->selected = $selected;
    }

    public function isSelected($option) {
        return $option === $this->selected;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.radio-button');
    }
}
