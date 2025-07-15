<?php

namespace App\Support\Components;

#region USE

use ReflectionClass;
use Illuminate\Support\Str;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class AbstractComponent
{
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
        return array_merge($this->props, [
            'component' => $this->getComponent(),
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return string
     */
    protected function getComponent(): string
    {
        $name = (new ReflectionClass(static::class))->getShortName();

        return Str::slug(Str::snake($name));
    }

    #endregion
}
