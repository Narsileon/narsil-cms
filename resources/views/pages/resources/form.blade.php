@extends('narsil::layouts.auth')

@section('body')
	<x-narsil::blocks.resource-form
		:form-data="$data ?? []"
		:form="$form"
	>
		@if ($revisions ?? false)
			<x-slot:status>
				<div
					class="flex items-center gap-1 overflow-hidden transition-[width] delay-100 duration-300"
				>
					@if (data_get($data, 'has_published_revision'))
						<span
							aria-label="{{ trans('narsil-cms::revisions.published') }}"
							class="size-2 shrink-0 rounded-full bg-green-500"
							role="img"
							title="{{ trans('narsil-cms::revisions.published') }}"
						></span>
					@endif
					@if (data_get($data, 'has_new_revision'))
						<span
							aria-label="{{ trans('narsil-cms::revisions.saved') }}"
							class="size-2 shrink-0 rounded-full bg-amber-500"
							role="img"
							title="{{ trans('narsil-cms::revisions.saved') }}"
						></span>
					@endif
					@if (data_get($data, 'has_draft'))
						<span
							aria-label="{{ trans('narsil-cms::revisions.draft') }}"
							class="size-2 shrink-0 rounded-full bg-red-500"
							role="img"
							title="{{ trans('narsil-cms::revisions.draft') }}"
						></span>
					@endif
				</div>
			</x-slot:status>
		@endif

		@if ($publish ?? false)
			<x-slot:publish>
				<div
					class="grid gap-2 border-b px-4 pb-4 pt-2"
				>
					@foreach (data_get($publish, 'steps', []) as $step)
						@foreach (data_get($step, 'elements', []) as $element)
							<x-narsil::ui.form.form-element
								:element="$element"
								:languages="data_get($publish, 'languages', [])"
							/>
						@endforeach
					@endforeach
				</div>
			</x-slot:publish>
		@endif

		@if ($revisions ?? false)
			<x-slot:revisions>
				<div
					class="grid gap-3 border-t p-4"
				>
					<x-narsil::blocks.select.select-root
						:id="'revision'"
						:options="collect($revisions)
						    ->map(fn($revision) => ['label' => 'Revision ' . $revision->revision, 'value' => $revision->uuid])
						    ->all()"
						:value="request('revision', data_get($revisions, '0.uuid'))"
						trigger-class="w-full"
						x-on:select-change.window="if ($event.detail.id === 'revision') { const params = new URLSearchParams(window.location.search); params.set('revision', $event.detail.value); window.location.search = params.toString(); }"
					/>
				</div>
			</x-slot:revisions>
		@endif

		@if ($countries ?? false)
			<x-slot:countries>
				<div
					class="grid gap-1 border-b p-2"
				>
					<div
						class="flex items-center justify-start gap-2 pl-2.5"
					>
						<x-narsil::ui.icon.icon-root
							class="size-4"
							name="fa-solid-globe"
						/>
						<x-narsil::ui.heading.heading-root
							level="h3"
							variant="discreet"
						>
							{{ trans('narsil-cms::ui.countries') }}
						</x-narsil::ui.heading.heading-root>
					</div>
					<div
						class="grid gap-1"
					>
						@foreach ($countries as $country)
							@php
								$countryValue = data_get($country, 'value');
								$selectedCountry = request('country', data_get($countries, '0.value')) == $countryValue;
							@endphp
							<a
								aria-current="{{ $selectedCountry ? 'true' : 'false' }}"
								class="hover:bg-accent {{ $selectedCountry ? 'bg-accent' : '' }} flex min-h-9 items-center rounded-md px-2.5 transition-colors"
								href="{{ request()->fullUrlWithQuery(['country' => $countryValue]) }}"
								wire:navigate
							>
								<span
									class="{{ $selectedCountry ? 'before:animate-pulse before:bg-constructive' : 'before:bg-foreground' }} relative pl-5 font-normal before:absolute before:left-0 before:top-1/2 before:size-1.5 before:-translate-y-1/2 before:rounded-full"
								>
									{{ data_get($country, 'label') }}
								</span>
							</a>
						@endforeach
					</div>
				</div>
			</x-slot:countries>
		@endif
	</x-narsil::blocks.resource-form>
@endsection
