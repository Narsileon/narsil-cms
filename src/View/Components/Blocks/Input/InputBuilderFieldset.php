<?php

declare(strict_types=1);

namespace Narsil\Cms\View\Components\Blocks\Input;

#region USE

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

#endregion

final class InputBuilderFieldset extends Component
{
    #region CONSTRUCTOR

    public function __construct(
        mixed $fieldset,
        mixed $id,
        mixed $languages = [],
        mixed $value = null,
    ) {
        $this->fieldset = $fieldset;
        $this->id = $id;
        $this->languages = $languages;
        $this->value = $value;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var mixed
     */
    public readonly mixed $fieldset;

    /**
     * @var mixed
     */
    public readonly mixed $id;

    /**
     * @var mixed
     */
    public readonly mixed $languages;

    /**
     * @var mixed
     */
    public readonly mixed $value;

    #endregion

    #region PUBLIC METHODS

    public function render(): View
    {
        return view('narsil-cms::components.blocks.input.input-builder-fieldset');
    }

    #endregion
}
