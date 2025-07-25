<?php

namespace Narsil\Fields;

#region USE

use Narsil\Contracts\Fields\AbstractField as Contract;
use Narsil\Enums\Fields\PropEnum;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @param string $type
     *
     * @return void
     */
    public function __construct(
        string $type,
        string $icon,
        string $label,
    )
    {
        $this->icon = $icon;
        $this->label = $label;

        $this->settings[PropEnum::TYPE->value] = $type;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var string The icon of the field.
     */
    public readonly string $icon;
    /**
     * @var string The label of the field.
     */
    public readonly string $label;

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
