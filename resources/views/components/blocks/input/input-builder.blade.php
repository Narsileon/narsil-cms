<div
	class="relative col-span-full flex flex-col items-center justify-center rounded px-4 py-2"
	data-builder-id="{{ $builderKey }}"
	data-builder-name="{{ $name }}"
	data-builder-path="{{ $id }}"
	x-data="narsilSortableList({
    itemsRef: 'items',
    itemSelector: ':scope > [data-builder-item]',
    templateSelector: ':scope > template[data-builder-template]',
    indexToken: {{ Illuminate\Support\Js::from($indexToken) }},
    uuidToken: {{ Illuminate\Support\Js::from($uuidToken) }},
    prefix: {{ Illuminate\Support\Js::from($name) }},
    idPrefix: {{ Illuminate\Support\Js::from($id) }},
    keepEmptyContainer: true,
})"
	x-on:sortable-list-move.window="moveById($event.detail.id, $event.detail.direction)"
	x-on:sortable-list-remove.window="removeById($event.detail.id)"
	x-on:narsil-builder-add.window="if ($event.detail.builderId === $el.dataset.builderId) add($event.detail.blockId, $event.detail.placeholderId)"
>
	<input
		name="{{ $name }}"
		type="hidden"
		value=""
	>
	<div
		class="flex w-full flex-col items-center justify-center"
		x-ref="items"
		x-sort:config="{ draggable: '[data-builder-item]' }"
		x-sort="sync()"
	>
		@foreach ($items as $index => $item)
			@php
				$itemUuid = data_get($item, 'uuid', 'item-' . $index);
				$block = $blocks[(string) data_get($item, 'block_id')] ?? null;
			@endphp
			<x-narsil-cms::blocks.input.input-builder-add
				:blocks="$blocks"
				:builder-id="$builderKey"
				:connect-above="$index > 0"
				:placeholder="$itemUuid"
				:class="$index === 0 ? 'mb-2' : 'mt-2 mb-2'"
			/>
			<x-narsil-cms::blocks.input.input-builder-item
				:block="$block"
				:builder-id="$id"
				:builder-name="$name"
				:item="$item"
				:item-index="$index"
				:item-uuid="$itemUuid"
				:languages="$languages"
			/>
		@endforeach
		@if ($blocks !== [])
			<x-narsil-cms::blocks.input.input-builder-add
				:blocks="$blocks"
				:builder-id="$builderKey"
				:connect-above="$items !== []"
				:tail="true"
				:class="$items === [] ? '' : 'not-first:mt-2'"
			/>
		@endif
	</div>
	@foreach ($blocks as $block)
		<template
			data-builder-template="{{ data_get($block, 'block_id') }}"
		>
			<x-narsil-cms::blocks.input.input-builder-item
				:block="$block"
				:builder-id="$id"
				:builder-name="$name"
				:item="[]"
				:item-index="$indexToken"
				:item-uuid="$uuidToken"
				:languages="$languages"
			/>
		</template>
	@endforeach
	<div class="absolute top-0 -z-10 size-full">
		<svg
			class="bg-sidebar pointer-events-none absolute inset-0 size-full"
			data-slot="background-grid"
		>
			<defs>
				<pattern
					id="{{ $name }}"
					width="16"
					height="16"
					patternUnits="userSpaceOnUse"
				>
					<path
						class="stroke-border"
						d="M 16 0 L 0 0 0 16"
						fill="none"
						stroke-width="0.5"
					/>
				</pattern>
			</defs>
			<rect
				width="100%"
				height="100%"
				fill="url(#{{ $name }})"
				mask="url(#fade-mask)"
			/>
		</svg>
	</div>
</div>
