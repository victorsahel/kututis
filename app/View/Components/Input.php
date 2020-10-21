<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    /**
     * @var false|mixed
     */
    public $name;
    public $required;
    public $value;
    public $type;

    /**
     * Create a new component instance.
     * @param string $name
     * @param $value
     * @param bool $required
     * @param string $type
     */
    public function __construct(string $name, $value = null, $required = false, string $type = "text")
    {
        $this->name = $name;
        $this->required = $required;
        $this->value = $value;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.input');
    }
}
