<div
	{{ $attributes->twMerge('flex items-center gap-1') }}
>
	@if ($published)
		<span
			aria-label="{{ trans('narsil-cms::revisions.published') }}"
			class="size-2 shrink-0 rounded-full bg-green-500"
			role="img"
			title="{{ trans('narsil-cms::revisions.published') }}"
		></span>
	@endif
	@if ($saved)
		<span
			aria-label="{{ trans('narsil-cms::revisions.saved') }}"
			class="size-2 shrink-0 rounded-full bg-amber-500"
			role="img"
			title="{{ trans('narsil-cms::revisions.saved') }}"
		></span>
	@endif
	@if ($draft)
		<span
			aria-label="{{ trans('narsil-cms::revisions.draft') }}"
			class="size-2 shrink-0 rounded-full bg-red-500"
			role="img"
			title="{{ trans('narsil-cms::revisions.draft') }}"
		></span>
	@endif
</div>
