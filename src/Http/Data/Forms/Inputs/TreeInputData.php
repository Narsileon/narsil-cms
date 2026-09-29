<?php

declare(strict_types=1);

namespace Narsil\Cms\Http\Data\Forms\Inputs;

#region USE

use Narsil\Base\Http\Data\Forms\InputData;

#endregion

/**
 * @property array $defaultValue The value of the "default value" attribute.
 * @property bool $rootExclusive Whether the tree has one exclusive root item.
 */
class TreeInputData extends InputData
{
    #region CONSTRUCTOR

    /**
     * @param array $defaultValue The value of the "default value" attribute.
     * @param bool $rootExclusive Whether the tree has one exclusive root item.
     *
     * @return void
     */
    public function __construct(
        array $defaultValue = [],
        bool $rootExclusive = false,
    ) {
        $this->set(self::DEFAULT_VALUE, $defaultValue);
        $this->set(self::ROOT_EXCLUSIVE, $rootExclusive);

        parent::__construct(static::TYPE);
    }

    #endregion

    #region CONSTANTS

    /**
     * The name of the "root exclusive" attribute.
     *
     * @var string
     */
    final public const ROOT_EXCLUSIVE = 'rootExclusive';

    /**
     * The name of the "type" attribute.
     *
     * @var string
     */
    final public const TYPE = 'tree';

    #endregion
}
