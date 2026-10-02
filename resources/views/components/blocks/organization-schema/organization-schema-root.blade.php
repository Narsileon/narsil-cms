@if ($schema)
	<script
		{{ $attributes->twMerge()->merge([
		    'data-slot' => 'organization-schema-root',
		]) }}
		type="application/ld+json"
	>
		{!! json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
	</script>
@endif
