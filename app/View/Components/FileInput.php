<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FileInput extends Component
{
    public $name;
    public $required;
    public $value;
    public $accept;
    public $preview;
    public $key;

    public $base64;
    public $preloaded;

    /**
     * Create a new component instance.
     * @param string $name
     * @param $value
     * @param bool $required
     * @param string|null $accept
     * @param string|null $preview
     */
    public function __construct(string $name, $value = null, $required = false, string $accept = null, string $preview = null)
    {
        $this->name = $name;
        $this->required = $required;
        $this->value = $value;
        $this->accept = $accept;
        $this->preview = $preview;
        $this->key = $name.'_tmp';

        $this->base64 = session($this->key) ? asset('storage/'.session($this->key)) : '';
        $this->preloaded = session($name.'_load') ? asset('storage/'.session($name.'_load')) : '';
    }

    public function isRequired()
    {
        return $this->required;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.file-input');
    }
}
