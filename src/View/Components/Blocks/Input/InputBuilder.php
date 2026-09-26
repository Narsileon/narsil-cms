<?php

declare(strict_types=1);

namespace Narsil\Cms\View\Components\Blocks\Input;

#region USE

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

#endregion

final class InputBuilder extends Component
{
    #region CONSTRUCTOR

    public function __construct(
        mixed $element,
        mixed $id,
        mixed $input,
        mixed $languages = [],
        mixed $name = null,
        mixed $value = null,
    ) {
        $this->element = $element;
        $this->id = $id;
        $this->input = $input;
        $this->languages = $this->resolveLanguages($languages);
        $this->name = $name ?? (string) $id;
        preg_match_all('/__BUILDER_INDEX_(\d+)__/', (string) $id, $matches);

        $parentDepth = $matches[1] === [] ? null : (int) end($matches[1]);
        $depth = $parentDepth === null ? 0 : $parentDepth + 1;

        $this->indexToken = "__BUILDER_INDEX_{$depth}__";
        $this->uuidToken = "__BUILDER_UUID_{$depth}__";
        $this->builderKey = (string) Str::uuid() . ($parentDepth === null ? '' : "-__BUILDER_UUID_{$parentDepth}__");
        $this->items = $this->resolveItems($value);
        $this->blocks = $this->resolveBlocks($input);
    }

    #endregion

    #region PROPERTIES

    /**
     * @var mixed
     */
    public readonly mixed $element;

    /**
     * @var mixed
     */
    public readonly mixed $id;

    /**
     * @var mixed
     */
    public readonly mixed $input;

    /**
     * @var array<int,array{label:mixed,value:string}>
     */
    public readonly array $languages;

    /**
     * @var string
     */
    public readonly string $name;

    /**
     * @var string
     */
    public readonly string $builderKey;

    /**
     * @var string
     */
    public readonly string $indexToken;

    /**
     * @var string
     */
    public readonly string $uuidToken;

    /**
     * @var array<int,mixed>
     */
    public readonly array $items;

    /**
     * @var array<string,mixed>
     */
    public readonly array $blocks;

    #endregion

    #region PUBLIC METHODS

    public function render(): View
    {
        return view('narsil-cms::components.blocks.input.input-builder');
    }

    #endregion

    #region PRIVATE METHODS

    private function resolveBlocks(mixed $input): array
    {
        $blocks = [];

        foreach (data_get($input, 'elements', []) as $block)
        {
            $blockId = data_get($block, 'block_id');

            if ($blockId === null)
            {
                continue;
            }

            $blocks[(string) $blockId] = $block;
        }

        return $blocks;
    }

    private function resolveItems(mixed $value): array
    {
        if (!is_array($value) && !is_object($value))
        {
            return [];
        }

        return array_values((array) $value);
    }

    private function resolveLanguages(mixed $languages): array
    {
        $resolvedLanguages = [];

        if (is_iterable($languages))
        {
            foreach ($languages as $language)
            {
                $value = (string) data_get($language, 'value', '');

                if ($value !== '')
                {
                    $resolvedLanguages[] = [
                        'label' => data_get($language, 'label', $value),
                        'value' => $value,
                    ];
                }
            }
        }

        if ($resolvedLanguages === [])
        {
            $locale = app()->getLocale();

            $resolvedLanguages[] = [
                'label' => $locale,
                'value' => $locale,
            ];
        }

        return $resolvedLanguages;
    }

    #endregion
}
