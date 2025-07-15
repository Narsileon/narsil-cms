<?php

namespace App\Support\Forms;

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
     * @param TypeEnum $type
     * @param mixed $defaultValue
     *
     * @return void
     */
    public function __construct(string $id, TypeEnum $type, mixed $defaultValue)
    {
        $this
            ->setId($id)
            ->setLabel(TableService::getHeading($id))
            ->setType($type)
            ->setValue($defaultValue);
    }

    #endregion

    #region PROPERTIES

    /**
     * @var array<string,mixed>
     */
    protected array $props = [];

    #endregion

    #region PUBLIC METHODS

    /**
     * @return array Returns the props.
     */
    final public function get(): array
    {
        return $this->props;
    }

    /**
     * @param AutoCompleteEnum $autoComplete
     *
     * @return static Returns the current object instance.
     */
    final public function setAutoComplete(AutoCompleteEnum $autoComplete): static
    {
        $this->props['auto_complete'] = $autoComplete->value;

        return $this;
    }

    /**
     * @param boolean $column
     *
     * @return static Returns the current object instance.
     */
    final public function setColumn(bool $column): static
    {
        $this->props['column'] = $column;

        return $this;
    }

    /**
     * @param string $description
     *
     * @return static Returns the current object instance.
     */
    final public function setDescription(string $description): static
    {
        $this->props['description'] = $description;

        return $this;
    }

    /**
     * @param string $id
     *
     * @return static Returns the current object instance.
     */
    final public function setId(string $id): static
    {
        $this->props['id'] = $id;

        return $this;
    }

    /**
     * @param string $label
     *
     * @return static Returns the current object instance.
     */
    final public function setLabel(string $label): static
    {
        $this->props['label'] = $label;

        return $this;
    }

    /**
     * @param integer|float $max
     *
     * @return static Returns the current object instance.
     */
    final public function setMax(int|float $max): static
    {
        $this->props['max'] = $max;

        return $this;
    }

    /**
     * @param integer|float $min
     *
     * @return static Returns the current object instance.
     */
    final public function setMin(int|float $min): static
    {
        $this->props['min'] = $min;

        return $this;
    }

    /**
     * @param array $options
     *
     * @return static Returns the current object instance.
     */
    final public function setOptions(array $options): static
    {
        $this->props['options'] = $options;

        return $this;
    }

    /**
     * @param string $placeholder
     *
     * @return static Returns the current object instance.
     */
    final public function setPlaceholder(string $placeholder): static
    {
        $this->props['placeholder'] = $placeholder;

        return $this;
    }

    /**
     * @param boolean $required
     *
     * @return static Returns the current object instance.
     */
    final public function setRequired(bool $required): static
    {
        $this->props['required'] = $required;

        return $this;
    }

    /**
     * @param integer|float $step
     *
     * @return static Returns the current object instance.
     */
    final public function setStep(int|float $step): static
    {
        $this->props['step'] = $step;

        return $this;
    }

    /**
     * @param TypeEnum $type
     *
     * @return static Returns the current object instance.
     */
    final public function setType(TypeEnum $type): static
    {
        $this->props['type'] = $type->value;

        return $this;
    }

    /**
     * @param mixed $value
     *
     * @return static Returns the current object instance.
     */
    final public function setValue(mixed $value): static
    {
        $this->props['value'] = $value;

        return $this;
    }

    #endregion
}
