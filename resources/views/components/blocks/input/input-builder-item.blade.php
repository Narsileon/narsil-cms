<x-narsil::ui.collapsible.collapsible-root
	:open="true"
	class="w-full"
	data-builder-item
	data-sortable-item="{{ $itemUuid }}"
	x-sort:item="{{ $itemUuid }}"
>
	<x-narsil::ui.card.card-root
		x-data="{
            activationDialogOpen: false,
            pendingLanguage: '',
            pendingValue: false,
            setActiveLanguages(all) {
                this.$root.querySelectorAll('[data-builder-language]').forEach((element) => {
                    if (all || element.dataset.builderLanguage === this.pendingLanguage) {
                        const input = element.querySelector('input[type=checkbox]');
                        input.checked = this.pendingValue;
                        input.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                });
                this.activationDialogOpen = false;
            },
        }"
	>
		<input
			name="{{ $builderName }}[{{ $itemIndex }}][uuid]"
			type="hidden"
			value="{{ $itemUuid }}"
		>
		<input
			name="{{ $builderName }}[{{ $itemIndex }}][block_id]"
			type="hidden"
			value="{{ $blockId }}"
		>
		<x-narsil::ui.card.card-header
			class="py-0! flex min-h-9 items-center justify-between gap-2 pl-0 pr-1"
			x-bind:class="collapsibleOpen ? 'border-b' : ''"
		>
			<x-narsil::ui.sortable.sortable-handle
				aria-label="{{ trans('narsil::ui.move') }}"
			/>
			<button
				class="flex h-9 min-w-0 grow items-center justify-start px-2 text-start"
				type="button"
				x-on:click="collapsibleOpen = !collapsibleOpen"
			>
				<x-narsil::ui.card.card-title
					class="grow justify-self-start font-normal"
				>
					{{ data_get($block, 'label', trans('narsil::ui.definition')) }}
				</x-narsil::ui.card.card-title>
			</button>
			<div
				class="flex items-center gap-1"
			>
				@foreach ($languages as $language)
					@php
						$languageValue = $language['value'];
					@endphp
					<input
						name="{{ $builderName }}[{{ $itemIndex }}][active][{{ $languageValue }}]"
						type="hidden"
						value="0"
					>
					<div
						class="flex items-center"
						x-show="formLanguage === {{ Illuminate\Support\Js::from($languageValue) }}"
					>
					<x-narsil::blocks.switch.switch-root
						:checked="(bool) data_get($activeValues, $languageValue, $languageValue === app()->getLocale())"
						:name="$builderName . '[' . $itemIndex . '][active][' . $languageValue . ']'"
						:value="1"
						data-builder-language="{{ $languageValue }}"
						x-on:click.capture.prevent.stop="activationDialogOpen = true; pendingLanguage = {{ Illuminate\Support\Js::from($languageValue) }}; pendingValue = !checked"
						>
							<span
								class="sr-only"
							>
								{{ data_get($block, 'label', trans('narsil::ui.definition')) }}
								- {{ $language['label'] }}
							</span>
						</x-narsil::blocks.switch.switch-root>
					</div>
				@endforeach
				<x-narsil::blocks.sortable.sortable-item-menu
					:id="$itemUuid"
				>
					<x-narsil::ui.dropdown-menu.dropdown-menu-item
						class="text-destructive hover:bg-destructive/10 hover:text-destructive focus:bg-destructive/10 focus:text-destructive"
						data-sortable-item="{{ $itemUuid }}"
						x-on:click="$dispatch('sortable-list-remove', { id: $el.dataset.sortableItem }); dropdownOpen = false"
					>
						<x-narsil::ui.icon.icon-root
							class="text-destructive"
							name="fa-regular-trash"
						/>
						{{ trans('narsil::ui.delete') }}
					</x-narsil::ui.dropdown-menu.dropdown-menu-item>
				</x-narsil::blocks.sortable.sortable-item-menu>
				<x-narsil::ui.button.button-root
					class="shrink-0"
					size="icon-sm"
					variant="ghost"
					x-bind:aria-label="collapsibleOpen ? {{ Illuminate\Support\Js::from(trans('narsil::ui.collapse')) }} :
					    {{ Illuminate\Support\Js::from(trans('narsil::ui.expand')) }}"
					x-on:click="collapsibleOpen = !collapsibleOpen"
				>
					<x-narsil::ui.icon.icon-root
						class="duration-300"
						name="fa-regular-chevron-down"
						x-bind:class="collapsibleOpen ? 'rotate-0' : 'rotate-180'"
					/>
				</x-narsil::ui.button.button-root>
			</div>
		</x-narsil::ui.card.card-header>
		<x-narsil::ui.collapsible.collapsible-panel>
			<x-narsil::ui.card.card-content
				class="grid-cols-12"
			>
				@foreach (data_get($block, 'elements', []) as $childElement)
					@php
						$childId = data_get($childElement, 'id');
						$nestedElements = data_get($childElement, 'elements');
						$childPath = $builderId . '.' . $itemIndex . '.children.' . $childId;
						$childValue = data_get($item, 'children.' . $childId);
					@endphp
					@if (is_array($nestedElements) || $nestedElements instanceof \Traversable)
						<x-narsil-cms::blocks.input.input-builder-fieldset
							:fieldset="$childElement"
							:id="$childPath"
							:languages="$languages"
							:value="$childValue"
						/>
					@else
						<x-narsil::ui.form.form-element
							:element="$childElement"
							:id="$childPath"
							:languages="$languages"
							:value="$childValue"
						/>
					@endif
				@endforeach
			</x-narsil::ui.card.card-content>
		</x-narsil::ui.collapsible.collapsible-panel>
		<div
			class="fixed inset-0 z-50 bg-black/50"
			x-cloak
			x-on:click.self="activationDialogOpen = false"
			x-show="activationDialogOpen"
		></div>
		<section
			aria-modal="true"
			class="bg-background text-foreground ring-foreground/10 fixed top-1/2 left-1/2 z-50 grid w-full max-w-xs -translate-x-1/2 -translate-y-1/2 gap-4 rounded-xl p-4 shadow-lg outline-none ring-1 sm:max-w-sm"
			role="alertdialog"
			x-cloak
			x-on:keydown.escape.window="activationDialogOpen = false"
			x-show="activationDialogOpen"
		>
			<x-narsil::ui.alert-dialog.alert-dialog-header>
				<x-narsil::ui.alert-dialog.alert-dialog-title>
					<span x-show="pendingValue">{{ trans('narsil-cms::dialogs.titles.activation') }}</span>
					<span x-show="!pendingValue">{{ trans('narsil-cms::dialogs.titles.deactivation') }}</span>
				</x-narsil::ui.alert-dialog.alert-dialog-title>
				<x-narsil::ui.alert-dialog.alert-dialog-description>
					<span x-show="pendingValue">{{ trans('narsil-cms::dialogs.descriptions.activation') }}</span>
					<span x-show="!pendingValue">{{ trans('narsil-cms::dialogs.descriptions.deactivation') }}</span>
				</x-narsil::ui.alert-dialog.alert-dialog-description>
			</x-narsil::ui.alert-dialog.alert-dialog-header>
			<x-narsil::ui.alert-dialog.alert-dialog-footer>
				<x-narsil::ui.alert-dialog.alert-dialog-action
					type="button"
					x-on:click="setActiveLanguages(false)"
				>
					{{ trans('narsil-cms::dialogs.buttons.this_language') }}
				</x-narsil::ui.alert-dialog.alert-dialog-action>
				<x-narsil::ui.alert-dialog.alert-dialog-action
					type="button"
					x-on:click="setActiveLanguages(true)"
				>
					{{ trans('narsil-cms::dialogs.buttons.all_languages') }}
				</x-narsil::ui.alert-dialog.alert-dialog-action>
				<x-narsil::ui.alert-dialog.alert-dialog-cancel
					x-on:click="activationDialogOpen = false"
				>
					{{ trans('narsil::ui.cancel') }}
				</x-narsil::ui.alert-dialog.alert-dialog-cancel>
			</x-narsil::ui.alert-dialog.alert-dialog-footer>
		</section>
	</x-narsil::ui.card.card-root>
</x-narsil::ui.collapsible.collapsible-root>
