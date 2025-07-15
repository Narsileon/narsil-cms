<?php

namespace App\Http\Forms;

#region USE

use App\Enums\Forms\MethodEnum;
use App\Contracts\Forms\Form;
use App\Support\Forms\Input;
use App\Support\LabelsBag;
use Illuminate\Support\Str;
use ReflectionClass;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractForm implements Form
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
            'action'  => $this->action,
            'content' => $this->getContent(),
            'id'      => $this->getId(),
            'method'  => $this->method,
            'options' => $this->getOptions(),
            'submit'  => $this->submit,
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
    abstract protected function getContent(): array;

    /**
     * @return string
     */
    protected function getId(): string
    {
        $name = (new ReflectionClass(static::class))->getShortName();

        return Str::slug(Str::snake($name));
    }

    /**
     * @return array
     */
    protected function getOptions(): array
    {
        return [];
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

    #endregion
}
