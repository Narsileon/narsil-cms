<li
	{{ $attributes->twMerge('list-none') }}
>
	<div
		@class([
			'group flex items-center gap-1 overflow-hidden rounded border pr-1',
			'border-primary bg-accent' => $isCurrentPage,
			'border-transparent hover:bg-accent/50' => !$isCurrentPage,
		])
	>
		<a
			class="flex min-w-0 grow items-center gap-2 px-2 py-1.5 text-left"
			href="{{ data_get($page, 'live_editor_url') }}"
		>
			<x-narsil::ui.icon.icon-root
				class="size-4 shrink-0"
				name="fa-regular-file"
			/>
			<span
				class="truncate"
			>
				{{ data_get($page, 'label') }}
			</span>
		</a>
		@if (data_get($page, 'create_url'))
			<x-narsil::ui.button.button-root
				:as-child="true"
				:href="data_get($page, 'create_url')"
				aria-label="{{ trans('narsil-cms::live-editor.pages.create') }}"
				class="shrink-0 opacity-0 group-hover:opacity-100"
				size="icon-sm"
				variant="ghost"
			>
				<x-narsil::ui.icon.icon-root
					class="size-4"
					name="fa-regular-plus"
				/>
			</x-narsil::ui.button.button-root>
		@endif
	</div>
	@if (data_get($page, 'children'))
		<div
			class="ml-3 mt-1 border-l pl-2"
		>
			<ul
				class="grid gap-1"
			>
				@foreach (data_get($page, 'children') as $childPage)
					<x-narsil-cms::blocks.live-editor.page-tree-item
						:current-site-page-id="$currentSitePageId"
						:page="$childPage"
					/>
				@endforeach
			</ul>
		</div>
	@endif
</li>
