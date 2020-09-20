<?php

namespace Paksuco\Modal\Components;

use Livewire\Component;

class Modal extends Component
{
    public $title;
    public $shown;
    public $view;
    public $item;
    public $args;
    public $isNewRecord;

    protected $listeners = ["showModal" => "show", "hideModal" => "hide"];

    public function mount()
    {
        $this->shown = false;
        $this->view = null;
        $this->args = null;
        $this->item = null;
        $this->isNewRecord = true;
    }

    public function show($title, $view, $args)
    {
        $this->resetErrorBag();
        $this->resetValidation();

        $this->title = $title;
        $this->view = $view;
        $this->args = $args;

        $class = $this->args["model"];

        $this->isNewRecord = $this->args["id"] == null;

        $item = $this->isNewRecord ?
        new $class :
        $class::find($this->args["id"]);

        $this->item = $item->toArray();

        $this->shown = true;
    }

    public function update()
    {
        $controller = app()->make($this->args["controller"]);
        $class = $this->args["model"];
        $item = $class::findOrFail($this->args["id"]);
        $result = $controller->update($item, $this->item);
        if ($result) {
            $this->hide();
            $this->emit("refresh");
        }
    }

    public function save()
    {
        $controller = app()->make($this->args["controller"]);
        $result = $controller->store($this->item);
        if ($result) {
            $this->hide();
            $this->emit("refresh");
        }
    }

    public function delete()
    {
        $controller = app()->make($this->args["controller"]);
        $class = $this->args["model"];
        $item = $class::findOrFail($this->args["id"]);
        $result = $controller->destroy($item);
        if ($result) {
            $this->hide();
            $this->emit("refresh");
        }
    }

    public function hide()
    {
        $this->shown = false;
    }

    public function render()
    {
        return view("paksuco-modal::components.modal");
    }
}
