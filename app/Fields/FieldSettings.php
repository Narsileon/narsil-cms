<?php

namespace App\Fields;

#region USE

use App\Contracts\Fields\FieldSettings as Contract;
use App\Enums\Fields\PropEnum;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class FieldSettings implements Contract
{
    #region CONSTRUCTOR

    /**
     * @param string $type
     *
     * @return void
     */
    public function __construct(string $type)
    {
        $this->settings[PropEnum::TYPE->value] = $type;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var array The settings of the field.
     */
    protected array $settings = [];

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function className(string $className): static
    {
        $this->settings[PropEnum::CLASS_NAME->value] = $className;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return $this->settings;
    }

    #endregion
}
