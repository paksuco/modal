<div class="relative mb-4 text-sm text-left" x-data="{open: true}" x-show="open">
    <div class="flex items-center bg-{{$color}}-100 text-{{$textcolor}} text-sm
        font-semibold break-words rounded px-4 py-3 border border-{{$color}}-300"
         role="alert">
        <i class="{{$icon}} mr-4 fa-2x leading-none"></i>
        <div class="leading-5">{!! $slot !!}</div>
        <span class="absolute inset-y-0 right-0 p-4 leading-none cursor-pointer" @click='open = false'>
            <i class="fa fa-times text-{{$textcolor}}"></i>
        </span>
    </div>
</div>
