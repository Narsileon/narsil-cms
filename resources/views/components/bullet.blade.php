@props(['label', 'color'])

<div class="flex items-center gap-2">
    <span class="block size-3 rounded-full bg-{{ $color }}-500"></span>
    <span>{{$label}}</span>
</div>