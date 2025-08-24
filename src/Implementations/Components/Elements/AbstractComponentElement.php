<?php

namespace Narsil\Implementations\Components\Elements;

#region USE

use Illuminate\Support\Str;
use JsonSerializable;
use ReflectionClass;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class AbstractComponentElement implements JsonSerializable
{
    #region PROPERTIES

    /**
     * @var array<string,mixed>
     */
    protected array $props = [];

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): mixed
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
        $name = new ReflectionClass(static::class)->getShortName();

        return Str::slug(Str::snake($name));
    }

    #endregion
}
