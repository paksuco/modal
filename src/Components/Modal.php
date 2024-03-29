<?php

namespace Paksuco\Modal\Components;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;

class Modal extends Component
{
    public $title;
    public $shown;
    public $view;
    public $item;
    public $args;
    public $modal_class;
    public $isNewRecord;
    public $dataUpdates;
    public $dataUpdated = false;

    protected $listeners = [
        "showModal" => "show",
        "hideModal" => "hide",
        "refreshModal" => "refreshModal",
        "setItemData" => "setItemData"
    ];

    public function mount($dataUpdates = [])
    {
        $this->modal_class = "";
        $this->shown = false;
        $this->view = null;
        $this->args = null;
        $this->item = null;
        $this->isNewRecord = true;
        $this->dataUpdates = $dataUpdates;
    }

    public function show($hash)
    {
        try {
            $decrypted = Crypt::decryptString($hash);
            $params = json_decode($decrypted, true);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return false;
        }

        extract($params, EXTR_OVERWRITE);

        $this->resetErrorBag();
        $this->resetValidation();

        $this->title = $title;
        $this->view = $view;
        $this->args = $params;

        $class = $this->args["model"];
        $instance = new $class;

        $this->modal_class = isset($args["modal_class"]) ? $args["modal_class"] : "";

        $this->isNewRecord = $this->args["id"] == null;

        $usesSoftDelete = $instance->hasGlobalScope('Illuminate\Database\Eloquent\SoftDeletingScope');

        $item = $this->isNewRecord ?
            $instance : ($usesSoftDelete ?
                $class::withTrashed()->find($this->args["id"]) :
                $class::find($this->args["id"]));

        $this->item = $item->toArray();

        foreach ($this->item as $key => $value) {
            $this->memberUpdate("item." . $key, $value);
        }

        $this->shown = true;
        $this->dispatchBrowserEvent("show-modal");
    }

    public function refreshModal()
    {
        $this->dataUpdated = !$this->dataUpdated;
        $this->shown = true;
        $this->render();
    }

    public function memberUpdate($name, $value)
    {
        if (array_key_exists($name, $this->dataUpdates)) {
            $this->dataUpdates[$name]($this, $value);
        }
    }

    public function updated($name, $value)
    {
        $this->memberUpdate($name, $value);
    }

    public function setItemData($data)
    {
        if (["key", "value"] === array_keys($data)) {
            $this->skipRender();
            $this->item[$data["key"]] = $data["value"];
        }
    }

    public function trigger($method, $params = [])
    {
        $controller = App::make($this->args["controller"]);
        if (method_exists($controller, $method)) {
            $result = $controller->callAction($method, array_merge($params, [
                "item" => $this->item
            ]));
            if ($result) {
                $this->hide();
                $this->emit("refresh");
            }
        }
    }

    public function hide()
    {
        $this->dispatchBrowserEvent("hide-modal");
        $this->shown = false;
    }

    public function render()
    {
        return view("paksuco-modal::components.modal");
    }
}
