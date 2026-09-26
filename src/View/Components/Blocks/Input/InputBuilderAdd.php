<?php

declare(strict_types=1);

namespace Narsil\Cms\View\Components\Blocks\Input;

#region USE

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

#endregion

final class InputBuilderAdd extends Component
{
    #region CONSTRUCTOR

    public function __construct(
        string $builderId,
        array $blocks,
        ?string $placeholder = null,
        bool $tail = false,
        bool $connectAbove = false,
    ) {
        $this->blocks = $blocks;
        $this->builderId = $builderId;
        $this->placeholder = $placeholder;
        $this->tail = $tail;
        $this->connectAbove = $connectAbove;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var array<int|string,mixed>
     */
    public readonly array $blocks;

    /**
     * @var string
     */
    public readonly string $builderId;

    /**
     * @var string|null
     */
    public readonly ?string $placeholder;

    /**
     * @var boolean
     */
    public readonly bool $tail;

    /**
     * @var boolean
     */
    public readonly bool $connectAbove;

    #endregion

    #region PUBLIC METHODS

    public function render(): View
    {
        return view('narsil-cms::components.blocks.input.input-builder-add');
    }

    #endregion
}
