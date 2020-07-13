<?php

namespace Paksuco\Modal\Components;

use Facade\Ignition\Exceptions\ViewException;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\View\View;

class Modal extends Component
{
    public $title;
    public $shown;
    public $view;
    public $args;

    protected $listeners = ["showModal" => "open", "closeModal" => "close"];

    public function mount()
    {
        $this->shown = false;
        $this->view = null;
        $this->args = null;
    }

    public function open($title, $view, $args)
    {
        $this->title = $title;
        $this->view = $view;
        $this->args = $args;
        $this->shown = true;
    }

    public function close()
    {
        $this->shown = false;
    }

    public function render()
    {
        return view("paksuco-modal::components.modal");
    }
}
