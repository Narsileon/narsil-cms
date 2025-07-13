<?php

namespace App\Http\Forms;

#region USE

use App\Enums\Forms\MethodEnum;
use App\Interfaces\Forms\IForm;
use App\Support\Input;
use App\Support\LabelsBag;
use Illuminate\Support\Str;
use ReflectionClass;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractForm implements IForm
{
    #region PUBLIC METHODS

    /**
     * {@inheritdoc}
     */
    public function get(
        string $action,
        MethodEnum $method,
        string $submit,
    ): array
    {
        $this->action = $action;
        $this->method = $method->value;
        $this->submit = $submit;

        $this->registerLabels();

        return [
            'action'       => $this->action,
            'method'       => $this->method,
            'id'           => $this->getId(),
            'inputs'       => $this->getInputs(),
            'options'      => $this->getOptions(),
            'submit'       => $this->submit,
        ];
    }

    #endregion

    #region PROPERTIES

    /**
     * @var string
     */
    public readonly string $action;
    /**
     * @var string
     */
    public readonly string $method;
    /**
     * @var string
     */
    public readonly string $submit;

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<Input>
     */
    abstract protected function getInputs(): array;


    /**
     * @return string
     */
    protected function getId(): string
    {
        $name = (new ReflectionClass(static::class))->getShortName();

        return Str::slug(Str::snake($name));
    }

    /**
     * @return void
     */
    protected function registerLabels(): void
    {
        app(LabelsBag::class)
            ->add('ui.back')
            ->add('pagination.empty')
            ->add('accessibility.required');
    }

    /**
     * @return array
     */
    protected function getOptions(): array
    {
        return [];
    }

    #endregion
}
