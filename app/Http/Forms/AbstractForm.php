<?php

namespace App\Http\Forms;

#region USE

use App\Enums\Forms\MethodEnum;
use App\Structures\Input;
use Illuminate\Support\Str;
use ReflectionClass;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractForm
{
    #region PUBLIC METHODS

    /**
     * @param string $action,
     * @param MethodEnum $method,
     * @param string $submit,
     *
     * @return array
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

        return [
            'action'       => $this->action,
            'method'       => $this->method,
            'id'           => $this->getId(),
            'inputs'       => $this->getInputs(),
            'options'      => $this->getOptions(),
            'labels'       => $this->getLabels(),
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
     * @return array<string,string>
     */
    protected function getLabels(): array
    {
        return [
            'back'     => trans('ui.back'),
            'empty'    => trans('pagination.empty'),
            'required' => trans('accessibility.required'),
            'submit'   => $this->submit,
        ];
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
