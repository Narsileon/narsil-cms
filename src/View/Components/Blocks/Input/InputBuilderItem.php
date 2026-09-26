<?php

declare(strict_types=1);

namespace Narsil\Cms\View\Components\Blocks\Input;

#region USE

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

#endregion

final class InputBuilderItem extends Component
{
    #region CONSTRUCTOR

    public function __construct(
        string $builderId,
        string $builderName,
        string|int $itemIndex,
        string $itemUuid,
        mixed $item,
        mixed $block,
        array $languages = [],
    ) {
        $this->activeValues = data_get($item, 'active', []);
        $this->block = $block;
        $this->blockId = data_get($block, 'block_id', data_get($item, 'block_id'));
        $this->builderId = $builderId;
        $this->builderName = $builderName;
        $this->item = $item;
        $this->itemIndex = $itemIndex;
        $this->itemUuid = $itemUuid;
        $this->languages = $languages;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var mixed
     */
    public readonly mixed $activeValues;

    /**
     * @var mixed
     */
    public readonly mixed $block;

    /**
     * @var mixed
     */
    public readonly mixed $blockId;

    /**
     * @var string
     */
    public readonly string $builderId;

    /**
     * @var string
     */
    public readonly string $builderName;

    /**
     * @var mixed
     */
    public readonly mixed $item;

    /**
     * @var int|string
     */
    public readonly string|int $itemIndex;

    /**
     * @var string
     */
    public readonly string $itemUuid;

    /**
     * @var array<int,mixed>
     */
    public readonly array $languages;

    #endregion

    #region PUBLIC METHODS

    public function render(): View
    {
        return view('narsil-cms::components.blocks.input.input-builder-item');
    }

    #endregion
}
