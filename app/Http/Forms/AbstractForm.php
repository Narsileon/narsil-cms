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
    public static function get(
        string $action,
        MethodEnum $method,
        string $submit,
    ): array
    {
        return [
            'action' => $action,
            'method' => $method->value,
            'submit' => $submit,
            'id' => static::id(),
            'inputs' => static::inputs(),
            'options' => static::options(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<Input>
     */
    abstract protected static function inputs(): array;

    /**
     * @return string
     */
    protected static function id(): string
    {
        $name = (new ReflectionClass(static::class))->getShortName();

        return Str::slug(Str::snake($name));
    }

    /**
     * @return array<string>
     */
    protected static function options(): array
    {
        return [];
    }

    #endregion
}
