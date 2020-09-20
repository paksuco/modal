<?php

namespace Paksuco\Modal\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * The alert box color.
     *
     * @var string
     */
    public $color;

    /**
     * The alert box text color.
     *
     * @var string
     */
    public $textcolor;

    /**
     * The alert box icon.
     *
     * @var string
     */
    public $icon;

    /**
     * Create the component instance.
     *
     * @param  string  $title
     * @param  string  $color
     * @param  string  $message
     * @return void
     */
    public function __construct($color, $textcolor, $icon)
    {
        $this->color = $color;
        $this->icon = $icon;
        $this->textcolor = $textcolor;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('paksuco-modal::components.alert');
    }
}
