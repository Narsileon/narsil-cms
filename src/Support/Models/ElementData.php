<?php

namespace Narsil\Support\Models;

#region USE

use Illuminate\Support\Fluent;
use Narsil\Models\AbstractCondition;

#endregion

class ConditionData extends Fluent
{
    #region CONSTRUCTOR

    /**
     * @param string $description
     * @param string $handle
     * @param string $label
     * @param boolean $required
     * @param boolean $translatable
     * @param integer $width
     *
     * @return void
     */
    public function __construct(
        string $description,
        string $handle,
        string $label,
        bool $required,
        bool $translatable,
        int $width
    )
    {
        $this->set('description', $description);
        $this->set('handle', $handle);
        $this->set('label', $label);
        $this->set('required', $required);
        $this->set('translatable', $translatable);
        $this->set('width', $width);
    }

    #endregion

    #region PROPERTIES

    #region PUBLIC METHODS

    /**
     * @param AbstractCondition $model
     *
     * @return static
     */
    public static function fromModel(Element $model): self
    {
        return new static(
            handle: $model->{AbstractCondition::HANDLE},
            operator: $model->{AbstractCondition::OPERATOR},
            value: $model->{AbstractCondition::VALUE},
        );
    }

    #endregion
}
