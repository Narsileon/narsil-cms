@if ($isBuilder)
	<div class="grid gap-1">
		<div class="flex items-center justify-between gap-1 pl-1">
			<div class="flex min-w-0 items-center gap-1.5 text-muted-foreground">
				<x-narsil::ui.icon.icon-root class="size-3.5 shrink-0" name="fa-solid-layer-group" />
				<span class="truncate text-xs font-medium tracking-wide uppercase">{{ data_get($node, 'label') }}</span>
			</div>
			@if (data_get($node, 'allowedBlocks'))
				<x-narsil::blocks.tooltip.tooltip-root :tooltip="trans('narsil-cms::live-editor.tree.add')">
					<x-narsil::ui.dropdown-menu.dropdown-menu-root>
						<x-narsil::ui.dropdown-menu.dropdown-menu-trigger
							aria-label="{{ trans('narsil-cms::live-editor.tree.add') }}"
							size="icon-sm"
							variant="ghost"
						>
							<x-narsil::ui.icon.icon-root class="size-4" name="fa-regular-plus" />
						</x-narsil::ui.dropdown-menu.dropdown-menu-trigger>
						<x-narsil::ui.dropdown-menu.dropdown-menu-portal>
							<x-narsil::ui.dropdown-menu.dropdown-menu-positioner align="start">
								<x-narsil::ui.dropdown-menu.dropdown-menu-popup>
									@foreach (data_get($node, 'allowedBlocks', []) as $block)
										<x-narsil::ui.dropdown-menu.dropdown-menu-item
											x-on:click="$dispatch('live-editor-add-block', { parentUuid: '{{ data_get($node, 'id') }}', blockId: {{ (int) data_get($block, 'block_id') }} }); $dispatch('dropdown-menu-close')"
										>
											<x-narsil::ui.icon.icon-root class="size-4" name="fa-solid-cubes-stacked" />
											<span>{{ data_get($block, 'label') }}</span>
										</x-narsil::ui.dropdown-menu.dropdown-menu-item>
									@endforeach
								</x-narsil::ui.dropdown-menu.dropdown-menu-popup>
							</x-narsil::ui.dropdown-menu.dropdown-menu-positioner>
						</x-narsil::ui.dropdown-menu.dropdown-menu-portal>
					</x-narsil::ui.dropdown-menu.dropdown-menu-root>
				</x-narsil::blocks.tooltip.tooltip-root>
			@endif
		</div>
		<ul
			@class([
				'grid gap-1',
				'hidden' => empty(data_get($node, 'children')),
			])
			data-builder-id="{{ data_get($node, 'id') }}"
		>
			@foreach (data_get($node, 'children', []) as $child)
				<x-narsil-cms::blocks.live-editor.content-tree-node
					:node="$child"
					:selected-node-id="$selectedNodeId"
				/>
			@endforeach
		</ul>
		@if (empty(data_get($node, 'children')))
			<p class="px-1 pb-1 text-xs text-muted-foreground italic">{{ trans('narsil-cms::live-editor.tree.empty') }}</p>
		@endif
	</div>
@else
	<li
		class="list-none"
		data-editor-node="{{ data_get($node, 'id') }}"
		x-on:dragover.prevent
		x-on:drop.stop.prevent="reorder($event, @js(data_get($node, 'id')))"
	>
		<div
			@class([
				'group flex items-center gap-1 overflow-hidden rounded border pr-1',
				'border-primary bg-accent' => $isSelected,
				'border-transparent hover:bg-accent/50' => !$isSelected,
			])
		>
			<span
				class="flex h-8 w-5 shrink-0 cursor-grab items-center justify-center text-muted-foreground active:cursor-grabbing"
				draggable="true"
				x-on:dragstart="$event.dataTransfer.setData('text/plain', @js(data_get($node, 'id'))); $event.dataTransfer.effectAllowed = 'move'; $el.closest('li')?.classList.add('opacity-50')"
				x-on:dragend="$el.closest('li')?.classList.remove('opacity-50')"
			>
				<x-narsil::ui.icon.icon-root class="size-3.5" name="fa-solid-grip-lines" />
			</span>
			<button
				class="flex min-w-0 grow items-center gap-2 py-1.5 text-left text-sm"
				type="button"
				wire:click="selectNode('{{ data_get($node, 'id') }}')"
			>
				<x-narsil::ui.icon.icon-root class="size-4 shrink-0" name="fa-solid-cubes-stacked" />
				<span class="truncate">{{ data_get($node, 'label') }}</span>
				@if (data_get($node, 'active') === false)
					<x-narsil::ui.icon.icon-root class="size-3.5 shrink-0 text-muted-foreground" name="fa-regular-eye-slash" />
				@endif
			</button>
			@if (data_get($node, 'meta.canDelete'))
				<x-narsil::blocks.tooltip.tooltip-root :tooltip="trans('narsil::ui.delete')">
					<x-narsil::ui.button.button-root
						aria-label="{{ trans('narsil::ui.delete') }}"
						class="shrink-0 opacity-0 group-hover:opacity-100"
						size="icon-sm"
						variant="ghost"
						wire:click="deleteNode('{{ data_get($node, 'id') }}')"
						wire:confirm="{{ trans('narsil::ui.delete') }}"
					>
						<x-narsil::ui.icon.icon-root class="size-4" name="fa-regular-trash-can" />
					</x-narsil::ui.button.button-root>
				</x-narsil::blocks.tooltip.tooltip-root>
			@endif
		</div>
		@if (data_get($node, 'children'))
			<div class="mt-1 ml-3 border-l pl-2">
				@foreach (data_get($node, 'children', []) as $child)
					<x-narsil-cms::blocks.live-editor.content-tree-node
						:node="$child"
						:selected-node-id="$selectedNodeId"
					/>
				@endforeach
			</div>
		@endif
	</li>
@endif
