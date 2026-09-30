<x-narsil::blocks.combobox.combobox-root
	:fetch-params="['collections' => $input->collections ?? []]"
	:id="$id"
	:min-search-length="3"
	:multiple="$input->multiple ?? false"
	:name="$name"
	:options="$options"
	:required="$element->required ?? false"
	:value="$value"
	{{ $attributes->twMerge() }}
	fetch-route="entities.search"
	value-path="identifier"
	x-on:combobox-change="translationValues[fieldLanguage] = $event.detail.value"
	x-on:field-language-change.window="value = translationValues[$event.detail.value] ?? ''"
	x-on:form-language-change.window="value = translationValues[$event.detail.value] ?? ''"
/>
