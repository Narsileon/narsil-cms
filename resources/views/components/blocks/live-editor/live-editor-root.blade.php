<div
	class="fixed inset-0 z-50 grid h-dvh min-h-0 grid-rows-[3.25rem_1fr] overflow-hidden bg-background text-foreground"
	data-selected-node-id="{{ $selectedNodeId ?? '' }}"
	x-data="narsilLiveEditor"
	x-on:live-editor-add-block.window="addBlock($event.detail.parentUuid, $event.detail.blockId)"
>
	<header class="grid grid-cols-[280px_1fr_380px] border-b">
		<x-narsil::blocks.sidebar.sidebar-header class="border-r bg-sidebar px-2 text-sidebar-foreground">
			<x-narsil::blocks.sidebar.sidebar-switcher
				:items="$home"
				:label="trans('narsil-cms::live-editor.title')"
				name="live-editor"
			/>
		</x-narsil::blocks.sidebar.sidebar-header>
		<div class="flex min-w-0 items-center gap-2 border-b bg-background px-4">
			@if ($bootstrap['siteLabel'])
				<span class="truncate text-sm font-medium">{{ $bootstrap['siteLabel'] }}</span>
			@endif
			<div class="ml-auto flex items-center gap-2">
				@if ($bootstrap['countries'])
					<label class="sr-only" for="live-editor-country">{{ trans('narsil-cms::live-editor.country') }}</label>
					<x-narsil::blocks.select.select-root
						:id="'live-editor-country'"
						:options="$bootstrap['countries']"
						:trigger-class="'min-w-24'"
						:value="$previewCountry"
						class="w-auto"
						x-on:select-change="$wire.changeCountry($event.detail.value)"
					/>
				@endif
				@if (count($bootstrap['pageForm']->languages) > 1)
					<label class="sr-only" for="live-editor-language">{{ trans('narsil-cms::live-editor.language') }}</label>
					<x-narsil::blocks.select.select-root
						:id="'live-editor-language'"
						:options="$bootstrap['pageForm']->languages"
						:trigger-class="'min-w-24'"
						:value="$previewLanguage"
						class="w-auto"
						x-on:select-change="$wire.changeLanguage($event.detail.value)"
					/>
				@endif
			</div>
		</div>
		<div class="flex h-13 items-center justify-end gap-2 border-b border-l bg-background px-4">
			<x-narsil::blocks.bookmarks.bookmarks-root
				:breadcrumb="$breadcrumb"
				:current-url="$currentUrl"
			/>
			<x-narsil::ui.dropdown-menu.dropdown-menu-root>
				<x-narsil::ui.dropdown-menu.dropdown-menu-trigger
					aria-label="{{ trans('narsil-cms::accessibility.user_menu') }}"
					class="hover:bg-accent hover:text-primary focus-visible:ring-ring inline-flex size-9 items-center justify-center rounded-full transition-colors focus-visible:outline-none focus-visible:ring-2"
				>
					<x-narsil::ui.avatar.avatar-root>
						@if (data_get($auth, 'avatar'))
							<x-narsil::ui.avatar.avatar-image
								:src="$auth->avatar"
								alt="{{ data_get($auth, 'full_name', 'User') }}"
							/>
						@endif
						<x-narsil::ui.avatar.avatar-fallback>
							<x-narsil::ui.icon.icon-root name="fa-solid-user" />
						</x-narsil::ui.avatar.avatar-fallback>
					</x-narsil::ui.avatar.avatar-root>
				</x-narsil::ui.dropdown-menu.dropdown-menu-trigger>
				<x-narsil::ui.dropdown-menu.dropdown-menu-portal>
					<x-narsil::ui.dropdown-menu.dropdown-menu-positioner align="end">
						<x-narsil::ui.dropdown-menu.dropdown-menu-popup class="border">
							@foreach ($menu as $item)
								@if (($item['id'] ?? null) === 'settings')
									<x-narsil::ui.dropdown-menu.dropdown-menu-item
										x-on:click="$dispatch('open-user-settings'); $dispatch('dialog-open')"
									>
										<x-narsil::ui.icon.icon-root :name="$item['icon'] ?? ''" class="text-primary size-5" />
										{{ $item['label'] }}
									</x-narsil::ui.dropdown-menu.dropdown-menu-item>
								@elseif (($item['method'] ?? \Narsil\Base\Enums\RequestMethodEnum::GET->value) === \Narsil\Base\Enums\RequestMethodEnum::GET->value)
									<x-narsil::ui.dropdown-menu.dropdown-menu-item
										:href="route($item['route'], $item['parameters'] ?? [])"
										wire:navigate
									>
										<x-narsil::ui.icon.icon-root :name="$item['icon'] ?? ''" class="text-primary size-5" />
										{{ $item['label'] }}
									</x-narsil::ui.dropdown-menu.dropdown-menu-item>
								@else
									<form action="{{ route($item['route'], $item['parameters'] ?? []) }}" method="POST">
										@csrf
										@if (($item['method'] ?? \Narsil\Base\Enums\RequestMethodEnum::GET->value) !== \Narsil\Base\Enums\RequestMethodEnum::POST->value)
											@method($item['method'])
										@endif
										<x-narsil::ui.dropdown-menu.dropdown-menu-item class="w-full" type="submit">
											<x-narsil::ui.icon.icon-root :name="$item['icon'] ?? ''" class="text-primary size-5" />
											{{ $item['label'] }}
										</x-narsil::ui.dropdown-menu.dropdown-menu-item>
									</form>
								@endif
							@endforeach
							<x-narsil::ui.dropdown-menu.dropdown-menu-separator />
							<div class="px-1 py-1">
								<livewire:narsil-theme />
							</div>
						</x-narsil::ui.dropdown-menu.dropdown-menu-popup>
					</x-narsil::ui.dropdown-menu.dropdown-menu-positioner>
				</x-narsil::ui.dropdown-menu.dropdown-menu-portal>
			</x-narsil::ui.dropdown-menu.dropdown-menu-root>
		</div>
	</header>

	<div class="grid min-h-0 grid-cols-[280px_minmax(0,1fr)_380px]">
		<aside class="flex min-h-0 flex-col overflow-hidden border-r bg-sidebar text-sidebar-foreground">
			<div class="flex min-h-0 basis-2/5 flex-col border-b">
				<div class="flex h-13 shrink-0 items-center justify-between gap-2 border-b px-4">
					<x-narsil::ui.heading.heading-root level="h2" variant="h6">
						{{ trans('narsil-cms::live-editor.pages.title') }}
					</x-narsil::ui.heading.heading-root>
					@if ($bootstrap['siteHostname'])
						<x-narsil::ui.button.button-root
							aria-label="{{ trans('narsil-cms::live-editor.pages.create') }}"
							:as-child="true"
							:href="route('sites.pages.create', ['site' => $bootstrap['siteHostname'], \Narsil\Cms\Models\Sites\SitePage::COUNTRY => $previewCountry])"
							size="icon-sm"
							variant="ghost"
						>
							<x-narsil::ui.icon.icon-root class="size-4" name="fa-regular-plus" />
						</x-narsil::ui.button.button-root>
					@endif
				</div>
				<div class="min-h-0 grow overflow-y-auto p-3">
					@if ($bootstrap['pages'])
						<ul class="grid gap-1">
							@foreach ($bootstrap['pages'] as $page)
								<x-narsil-cms::blocks.live-editor.page-tree-item
									:current-site-page-id="$bootstrap['sitePageId']"
									:page="$page"
								/>
							@endforeach
						</ul>
					@else
						<p class="text-sm text-muted-foreground">{{ trans('narsil-cms::live-editor.pages.empty') }}</p>
					@endif
				</div>
			</div>
			<div class="flex min-h-0 grow flex-col">
				<div class="flex h-13 shrink-0 items-center border-b px-4">
					<x-narsil::ui.heading.heading-root level="h2" variant="h6">
						{{ trans('narsil-cms::live-editor.tree.title') }}
					</x-narsil::ui.heading.heading-root>
				</div>
				<div class="min-h-0 grow overflow-y-auto">
					@if ($bootstrap['tree'])
						<div class="grid gap-3 p-3">
							@foreach ($bootstrap['tree'] as $node)
								@if (data_get($node, 'type') === 'builder')
									<x-narsil-cms::blocks.live-editor.content-tree-node
										:node="$node"
										:selected-node-id="$selectedNodeId"
									/>
								@else
									<ul class="grid gap-1">
										<x-narsil-cms::blocks.live-editor.content-tree-node
											:node="$node"
											:selected-node-id="$selectedNodeId"
										/>
									</ul>
								@endif
							@endforeach
						</div>
					@else
						<p class="p-4 text-sm text-muted-foreground">{{ trans('narsil-cms::live-editor.tree.empty') }}</p>
					@endif
				</div>
			</div>
		</aside>

		<main class="min-h-0 overflow-hidden bg-muted">
			@if ($bootstrap['previewUrl'])
				<iframe
					class="h-full w-full border-0 bg-white"
					data-live-editor-preview
					data-preview-version="{{ $previewVersion }}"
					src="{{ $bootstrap['previewUrl'] }}"
					title="{{ trans('narsil-cms::live-editor.preview.title') }}"
					wire:key="live-editor-preview-{{ $previewVersion }}"
				></iframe>
			@else
				<div class="flex h-full flex-col items-center justify-center gap-2 p-8 text-center">
					<x-narsil::ui.icon.icon-root class="size-6 text-muted-foreground" name="fa-regular-file" />
					<p class="max-w-sm text-sm text-muted-foreground">{{ trans('narsil-cms::live-editor.preview.missing') }}</p>
				</div>
			@endif
		</main>

		<aside class="min-h-0 overflow-hidden border-l bg-background">
			@if ($inspector)
				<div
					class="flex h-full min-h-0 flex-col overflow-hidden"
					wire:key="live-editor-inspector-{{ $selectedNodeId }}"
					x-data="{ formLanguage: @js($inspector['form']->defaultLanguage) }"
					x-on:form-language-change="formLanguage = $event.detail.value"
				>
					<div class="flex h-13 shrink-0 items-center justify-between gap-2 border-b px-4">
						<x-narsil::ui.heading.heading-root class="truncate" level="h2" variant="h6">
							{{ $inspector['label'] }}
						</x-narsil::ui.heading.heading-root>
						<x-narsil::ui.button.button-root
							class="disabled:cursor-wait"
							size="sm"
							type="button"
							wire:click="saveNode"
							wire:loading.attr="disabled"
							wire:target="saveNode"
						>
							<x-narsil::ui.icon.icon-root name="fa-regular-floppy-disk" />
							{{ trans('narsil::ui.save') }}
						</x-narsil::ui.button.button-root>
					</div>
					@if (count($inspector['form']->languages) > 1)
						<x-narsil::ui.form.form-language
							:default-language="$inspector['form']->defaultLanguage"
							:languages="$inspector['form']->languages"
							:value="$inspector['form']->defaultLanguage"
						/>
					@endif
					<div class="min-w-0 grow overflow-x-hidden overflow-y-auto p-4 [&_[data-slot=collapsible-root]]:min-w-0 [&_[data-slot=field-root]]:min-w-0">
						<x-narsil::ui.form.form-tabs
							:form-data="$blockData"
							:languages="$inspector['form']->languages"
							:model="'blockData'"
							:options="$inspector['options']"
							:steps="$inspector['form']->steps"
						/>
					</div>
				</div>
			@else
				<div
					class="flex h-full min-h-0 flex-col overflow-hidden"
					wire:key="live-editor-page-{{ $bootstrap['sitePageId'] }}"
					x-data="{ formLanguage: @js($bootstrap['pageForm']->defaultLanguage) }"
					x-on:form-language-change="formLanguage = $event.detail.value"
				>
					<div class="flex h-13 shrink-0 items-center justify-between gap-2 border-b px-4">
						<x-narsil::ui.heading.heading-root class="truncate" level="h2" variant="h6">
							{{ $bootstrap['sitePageTitle'] ?? trans('narsil-cms::live-editor.pages.title') }}
						</x-narsil::ui.heading.heading-root>
						<x-narsil::ui.button.button-root
							size="sm"
							type="button"
							wire:click="savePage"
							wire:loading.attr="disabled"
							wire:target="savePage"
						>
							<x-narsil::ui.icon.icon-root name="fa-regular-floppy-disk" />
							{{ trans('narsil::ui.save') }}
						</x-narsil::ui.button.button-root>
					</div>
					@if (count($bootstrap['pageForm']->languages) > 1)
						<x-narsil::ui.form.form-language
							:default-language="$bootstrap['pageForm']->defaultLanguage"
							:languages="$bootstrap['pageForm']->languages"
							:value="$bootstrap['pageForm']->defaultLanguage"
						/>
					@endif
					<div class="min-w-0 grow overflow-x-hidden overflow-y-auto p-4">
						<x-narsil::ui.form.form-tabs
							:form-data="$pageData"
							:languages="$bootstrap['pageForm']->languages"
							:model="'pageData'"
							:options="$bootstrap['pageForm']->options"
							:steps="$bootstrap['pageForm']->steps"
						/>
					</div>
				</div>
			@endif
		</aside>
	</div>
</div>
