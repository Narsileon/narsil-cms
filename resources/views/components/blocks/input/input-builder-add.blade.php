@php
	$classes = twMerge(
		'relative z-10 flex justify-center',
		"before:absolute before:bottom-full before:left-1/2 before:h-2 before:border-l before:border-dashed before:border-gray-500 before:content-['']",
		"after:absolute after:top-full after:left-1/2 after:h-2 after:border-l after:border-dashed after:border-gray-500 after:content-['']",
		'data-[builder-connect-above=false]:before:hidden data-[builder-connect-below=false]:after:hidden',
	);
@endphp

<div
	data-builder-id="{{ $builderId }}"
	data-builder-connect-above="{{ $connectAbove ? 'true' : 'false' }}"
	data-builder-connect-below="{{ $placeholder !== null ? 'true' : 'false' }}"
	@if ($placeholder !== null)
		data-builder-placeholder="{{ $placeholder }}"
	@endif
	@if ($tail)
		data-builder-tail
	@endif
	data-builder-add
	{{ $attributes->twMerge($classes) }}
>
	<x-narsil::blocks.tooltip.tooltip-root
		:tooltip="trans('narsil::ui.add')"
	>
		<x-narsil::ui.dropdown-menu.dropdown-menu-root
			class="contents"
		>
			<x-narsil::ui.dropdown-menu.dropdown-menu-trigger
				aria-label="{{ trans('narsil::ui.add') }}"
				class="rounded-full"
				size="icon-sm"
				variant="ghost"
			>
				<x-narsil::ui.icon.icon-root
					name="fa-regular-plus"
				/>
			</x-narsil::ui.dropdown-menu.dropdown-menu-trigger>
			<x-narsil::ui.dropdown-menu.dropdown-menu-portal>
				<x-narsil::ui.dropdown-menu.dropdown-menu-positioner
					align="end"
				>
					<x-narsil::ui.dropdown-menu.dropdown-menu-popup>
						@foreach ($blocks as $block)
							<x-narsil::ui.dropdown-menu.dropdown-menu-item
								data-builder-id="{{ $builderId }}"
								data-builder-block-id="{{ data_get($block, 'block_id') }}"
								:data-builder-placeholder-id="$placeholder ?? null"
								x-on:click="$dispatch('narsil-builder-add', { builderId: $el.dataset.builderId, blockId: $el.dataset.builderBlockId, placeholderId: $el.dataset.builderPlaceholderId }); $dispatch('dropdown-menu-close')"
							>
								@if (data_get($block, 'icon'))
									<x-narsil::ui.icon.icon-root
										:name="data_get($block, 'icon')"
									/>
								@endif
								{{ data_get($block, 'label', trans('narsil::ui.definition')) }}
							</x-narsil::ui.dropdown-menu.dropdown-menu-item>
						@endforeach
					</x-narsil::ui.dropdown-menu.dropdown-menu-popup>
				</x-narsil::ui.dropdown-menu.dropdown-menu-positioner>
			</x-narsil::ui.dropdown-menu.dropdown-menu-portal>
		</x-narsil::ui.dropdown-menu.dropdown-menu-root>
	</x-narsil::blocks.tooltip.tooltip-root>
</div>
