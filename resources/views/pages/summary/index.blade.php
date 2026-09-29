@extends('narsil::layouts.auth')

@section('body')
	<main
		class="flex min-h-full w-full items-center justify-center"
	>
		<div
			class="grid justify-center gap-6 p-6"
			style="grid-template-columns: repeat(auto-fit, minmax(12rem, 12rem));"
		>
			@foreach ($items as $item)
				<x-narsil::ui.card.card-root
					class="aspect-square h-48 w-48 cursor-pointer shadow-lg"
				>
					<a
						class="hover:bg-accent hover:text-accent-foreground flex h-full w-full items-center justify-center text-center transition-colors"
						href="{{ $item->href }}"
						wire:navigate
					>
						<x-narsil::ui.heading.heading-root
							level="h2"
							variant="h5"
						>
							{{ $item->name }}
						</x-narsil::ui.heading.heading-root>
					</a>
				</x-narsil::ui.card.card-root>
			@endforeach
		</div>
	</main>
@endsection
