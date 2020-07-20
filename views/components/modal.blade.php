@if($shown && $view)
<div class="pm-modal-container fixed flex overflow-y-scroll overflow-x-hidden inset-0 items-center justify-center w-screen h-screen"
     style="z-index: 20001">
    <div class="paksuco-modal absolute mx-auto my-auto bg-white z-10 rounded-lg text-sm shadow leading-none">
        <div class="pm-header font-semibold p-4 rounded-t bg-gray-200 capitalize">
            {!! $title !!}
        </div>
        <i class="fa fa-times absolute m-4 right-0 top-0 hover:text-gray-700 cursor-pointer" wire:click="close"></i>
        <div class="pm-body">
            @livewire($view, ["args" => $args])
        </div>
    </div>
    <div class="pm-modal-backdrop bg-opacity-50 bg-black w-screen h-screen absolute inset-0 z-0 pointer-events-none"></div>
</div>
@else
<div></div>
@endif
