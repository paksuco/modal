@if($view && $shown)
<div class="fixed inset-0 flex items-center justify-center w-screen h-screen overflow-y-auto paksuco-modal-container sm:py-12" style="z-index: 20001">
    <div tabindex="-1" class="paksuco-modal mx-auto my-auto bg-white z-10 rounded
        text-sm shadow-md leading-none p-4 {{isset($modal_class) ? $modal_class : ""}}">
        <div class="relative pb-2 pr-48 text-sm font-bold uppercase bg-white border-b rounded-t pm-header text-cool-gray-700">
            {!! $title !!}
            <div class="absolute inset-y-0 right-0 flex items-center align-center leading-0">
                <i class="pb-2 text-sm cursor-pointer fa fa-times text-cool-gray-700 hover:text-cool-gray-500" onclick="hideModal()"></i>
            </div>
        </div>
        <div class="pm-body">
            @if ($errors->any())
            <x-paksuco-modal-alert color="red" textcolor="white" icon="fa fa-exclamation-triangle">
                <p class="pl-1 pr-5 mb-2">@lang("Oops, there was a problem, please check your input and submit the form again.")</p>
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
    <div class="fixed inset-0 z-0 w-screen h-screen bg-black bg-opacity-50 pointer-events-none paksuco-modal-backdrop">
    </div>
</div>
@else
<div></div>
@endif

@push("head-styles")
<style>
    .paksuco-modal-container {
        transition: opacity 1s;
    }
</style>
@endpush

@push("footer-scripts")
<script>
    var showModal = function(...args) {
        livewire.emitTo("paksuco-modal::modal", "showModal", ...args);
        document.querySelector("body").classList.add("overflow-hidden");
    };
    var hideModal = function() {
        var modalContainer = document.querySelector(".paksuco-modal-container");
        livewire.emitTo("paksuco-modal::modal", "hideModal");
    };

    var wireFilter = function(items) {
        let output = [];
        for (let i of items) {
            let attributes = Array.prototype.slice.call(i.attributes).map(i => i.name).join(", ");
            if(/wire:model/.test(attributes)){
                output.push(i);
            }
        }
        return output;
    };

    window.addEventListener("show-modal", function(){
        var modalContainer = document.querySelector(".paksuco-modal-container");
        modalContainer.scrollTop = 0;
        modalContainer.addEventListener("click", function(e){
            if(e.target === modalContainer){
                document.querySelector(".paksuco-modal").focus();
            }
        });
        let filtered = wireFilter(modalContainer.querySelectorAll("*"));
        filtered.forEach(elem => {
            elem.dispatchEvent(new Event("input", { 'bubbles': true }));
        });
        document.querySelector(".paksuco-modal").focus();
    });

    window.addEventListener("hide-modal", function() {
        document.querySelector("body").classList.remove("overflow-hidden");
    });

    document.addEventListener('keyup', function (e) {
        if(e.target.classList.contains("paksuco-modal")){
            if ((e.key=='Escape'||e.key=='Esc'||e.keyCode==27)) {
                hideModal();
            }
        }
    }, true);
</script>
@endpush