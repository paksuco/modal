@if($view && $shown)
<div class="pm-modal-container fixed flex inset-0
    items-center justify-center w-screen h-screen" style="z-index: 20001">
    <div class="paksuco-modal absolute mx-auto my-auto bg-white z-10 rounded
        text-sm shadow-lg leading-none p-4">
        <div class="pm-header text-sm text-cool-gray-700 font-bold border-b pb-2
            pr-48 rounded-t bg-white uppercase relative">
            {!! $title !!}
            <div class="absolute flex items-center align-center inset-y-0 right-0 leading-0">
                <i class="fa fa-times text-cool-gray-700 text-sm hover:text-cool-gray-500
                    pb-2 cursor-pointer" wire:click="hide"></i>
            </div>
        </div>
        <div class="pm-body">
            @if ($errors->any())
            <x-paksuco-modal-alert color="red" textcolor="white" icon="fa fa-exclamation-triangle">
                <p class="mb-2 pl-1">@lang("Oops, there was a problem, please check your input and submit the form
                    again.")</p>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </x-paksuco-modal-alert>
            @endif
            @if (session("success"))
            <x-paksuco-settings-alert title="success" color="green" textcolor="white" icon="fa fa-check">
                {{ session("success") }}
            </x-paksuco-settings-alert>
            @endif


            @include($view)
        </div>
    </div>
    <div class="pm-modal-backdrop bg-opacity-50 bg-black w-screen h-screen absolute
        inset-0 z-0 pointer-events-none">
    </div>
</div>
@else
<div></div>
@endif
@push("footer-scripts")
<script>
    var hideModal = function() {
        livewire.emitTo("paksuco-modal::modal", "hideModal");
    };
    var showModal = function(...args) {
        livewire.emitTo("paksuco-modal::modal", "showModal", ...args);
    };
    window.addEventListener('keyup', function (e) {
        if ((e.key=='Escape'||e.key=='Esc'||e.keyCode==27)) {
            hideModal();
        }
    }, true);
</script>
@endpush