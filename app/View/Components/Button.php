<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $route;
    public $class;
    public $icon;
    public $method;
    public $confirm;

    public function __construct($route = '#', $class = 'primary', $icon = null, $method = 'GET', $confirm = false)
    {
        $this->route = $route;
        $this->class = $class;
        $this->icon = $icon;
        $this->method = strtoupper($method);
        $this->confirm = filter_var($confirm, FILTER_VALIDATE_BOOLEAN);
    }

    public function render()
    {
        return view('components.button');
    }
}
