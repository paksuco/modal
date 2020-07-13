<?php

namespace Paksuco\Modal\Components;

use Livewire\Component;

class Modal extends Component
{
    public function mount()
    {

    }

    public function render()
    {
        return view("paksuco-modal::components.modal", [
            "title" => "My Modal Title",
            "content" => "Here will be the modal content",
            "footer" => "My modal footer"
        ]);
    }
}
