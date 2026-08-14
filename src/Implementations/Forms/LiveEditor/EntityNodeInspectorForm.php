<?php

namespace Narsil\Cms\Implementations\Forms\LiveEditor;

#region USE

use Narsil\Base\Implementations\Form;
use Narsil\Cms\Contracts\Forms\LiveEditor\EntityNodeInspectorForm as Contract;
use Narsil\Cms\Http\Data\Forms\FormStepData;

#endregion

class EntityNodeInspectorForm extends Form implements Contract
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     *
     * @param array $elements
     */
    public function __construct(array $elements)
    {
        $this->elements = $elements;

        parent::__construct();
    }

    #endregion

    #region CONSTANTS

    /**
     * The identifier of the single step holding the node fields.
     *
     * @var string
     */
    final public const STEP = 'inspector';

    #endregion

    #region PROPERTIES

    /**
     * @var array
     */
    protected array $elements;

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getSteps(): array
    {
        return [
            new FormStepData(
                id: self::STEP,
                elements: $this->elements,
            ),
        ];
    }

    #endregion
}
