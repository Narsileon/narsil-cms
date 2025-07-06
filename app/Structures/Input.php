<?php

namespace App\Structures;

#region USE

use App\Enums\Forms\AutoCompleteEnum;
use App\Enums\Forms\TypeEnum;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Input
{
    #region CONSTRUCTOR

    /**
     * @param string $id
     *
     * @return void
     */
    public function __construct(string $id)
    {
        $this->props[self::ID] = $id;
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string
     */
    final public const AUTO_COMPLETE = 'auto_complete';
    /**
     * @var string
     */
    final public const COLUMN = 'column';
    /**
     * @var string
     */
    final public const DESCRIPTION = 'description';
    /**
     * @var string
     */
    final public const ID = 'id';
    /**
     * @var string
     */
    final public const PLACEHOLDER = 'placeholder';
    /**
     * @var string
     */
    final public const REQUIRED = 'required';
    /**
     * @var string
     */
    final public const TYPE = 'type';

    #endregion

    #region PROPERTIES

    /**
     * @var array<string,mixed>
     */
    protected array $props = [];

    #endregion

    #region PUBLIC METHODS

    /**
     * Gets the input prop.
     *
     * @return array Returns the props of the input.
     */
    final public function get(): array
    {
        return $this->props;
    }

    /**
     * Sets the autoComplete prop.
     *
     * @param AutoCompleteEnum $autoComplete
     *
     * @return static Returns the current object instance.
     */
    final public function autoComplete(AutoCompleteEnum $autoComplete): static
    {
        $this->props[self::AUTO_COMPLETE] = $autoComplete->value;

        return $this;
    }

    /**
     * Sets the column prop.
     *
     * @param boolean $column
     *
     * @return static Returns the current object instance.
     */
    final public function column(bool $column): static
    {
        $this->props[self::COLUMN] = $column;

        return $this;
    }

    /**
     * Sets the description prop.
     *
     * @param string $description
     *
     * @return static Returns the current object instance.
     */
    final public function description(string $description): static
    {
        $this->props[self::DESCRIPTION] = $description;

        return $this;
    }

    /**
     * Sets the placeholder prop.
     *
     * @param string $placeholder
     *
     * @return static Returns the current object instance.
     */
    final public function placeholder(string $placeholder): static
    {
        $this->props[self::PLACEHOLDER] = $placeholder;

        return $this;
    }

    /**
     * Sets the required props.
     *
     * @param boolean $required
     *
     * @return static Returns the current object instance.
     */
    final public function required(bool $required): static
    {
        $this->props[self::REQUIRED] = $required;

        return $this;
    }

    /**
     * Sets the type props.
     *
     * @param TypeEnum $type
     *
     * @return static Returns the current object instance.
     */
    final public function type(TypeEnum $type): static
    {
        $this->props[self::TYPE] = $type->value;

        return $this;
    }

    #endregion
}
