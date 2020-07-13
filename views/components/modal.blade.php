@if($shown && $view)
<div
     class="pm-modal-container fixed flex overflow-y-scroll overflow-x-hidden inset-0 items-center justify-center w-screen h-screen"
     style="z-index: 99999">
    <div class="paksuco-modal absolute mx-auto my-auto bg-white z-10 rounded text-sm shadow-lg leading-none">
        <div class="pm-header font-semibold p-4 rounded-t bg-gray-200">
            {!! $title !!}
        </div>
        <i class="fa fa-times absolute m-4 right-0 top-0 hover:text-gray-700 cursor-pointer" wire:click="close"></i>
        <div class="pm-body p-4" style="min-width: 400px">
            @livewire($view, ["args" => $args])
        </div>
    </div>
    <div class="pm-modal-backdrop bg-opacity-50 bg-black w-screen h-screen absolute inset-0 z-0"></div>
</div>
@else
<div></div>
@endif
