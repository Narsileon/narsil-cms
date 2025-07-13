<?php

namespace App\Support;

#region USE

use App\Enums\Forms\AutoCompleteEnum;
use App\Enums\Forms\TypeEnum;
use App\Services\TableService;

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
    public function __construct(string $id, mixed $defaultValue)
    {
        $this->props[self::ID] = $id;

        $this->label(TableService::getHeading($id));
        $this->value($defaultValue);
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string The name of "autoComplete" prop.
     */
    final public const AUTO_COMPLETE = 'auto_complete';
    /**
     * @var string The name of "column" prop.
     */
    final public const COLUMN = 'column';
    /**
     * @var string The name of "description" prop.
     */
    final public const DESCRIPTION = 'description';
    /**
     * @var string The name of "id" prop.
     */
    final public const ID = 'id';
    /**
     * @var string The name of "label" prop.
     */
    final public const LABEL = 'label';
    /**
     * @var string The name of "max" prop.
     */
    final public const MAX = 'max';
    /**
     * @var string The name of "min" prop.
     */
    final public const MIN = 'min';
    /**
     * @var string The name of "options" prop.
     */
    final public const OPTIONS = 'options';
    /**
     * @var string The name of "placeholder" prop.
     */
    final public const PLACEHOLDER = 'placeholder';
    /**
     * @var string The name of "required" prop.
     */
    final public const REQUIRED = 'required';
    /**
     * @var string The name of "step" prop.
     */
    final public const STEP = 'step';
    /**
     * @var string The name of "type" prop.
     */
    final public const TYPE = 'type';
    /**
     * @var string The name of "value" prop.
     */
    final public const VALUE = 'value';

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
     * Sets the label prop.
     *
     * @param string $label
     *
     * @return static Returns the current object instance.
     */
    final public function label(string $label): static
    {
        $this->props[self::LABEL] = $label;

        return $this;
    }

    /**
     * Sets the max prop.
     *
     * @param integer|float $max
     *
     * @return static Returns the current object instance.
     */
    final public function max(int|float $max): static
    {
        $this->props[self::MAX] = $max;

        return $this;
    }

    /**
     * Sets the min prop.
     *
     * @param integer|float $min
     *
     * @return static Returns the current object instance.
     */
    final public function min(int|float $min): static
    {
        $this->props[self::MIN] = $min;

        return $this;
    }

    /**
     * Sets the options prop.
     *
     * @param array $options
     *
     * @return static Returns the current object instance.
     */
    final public function options(array $options): static
    {
        $this->props[self::OPTIONS] = $options;

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
     * Sets the required prop.
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
     * Sets the step prop.
     *
     * @param integer|float $step
     *
     * @return static Returns the current object instance.
     */
    final public function step(int|float $step): static
    {
        $this->props[self::STEP] = $step;

        return $this;
    }

    /**
     * Sets the type prop.
     *
     * @param TypeEnum $type
     *
     * @return static Returns the current object instance.
     */
    final public function type(TypeEnum $type): static
    {
        $this->props[self::TYPE] = $type->value;

        if ($type === TypeEnum::COMBOBOX)
        {
            $this->placeholder(trans("placeholders.search"));
        }

        return $this;
    }

    /**
     * Sets the value prop.
     *
     * @param mixed $value
     *
     * @return static Returns the current object instance.
     */
    final public function value(mixed $value): static
    {
        $this->props[self::VALUE] = $value;

        return $this;
    }

    #endregion
}
