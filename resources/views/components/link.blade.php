@props(['label', 'route'])

<a
	class="hover:underline"
	href="{{ $route }}"
>
	{{ $label }}
</a>
