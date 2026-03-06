<?php

namespace Narsil\Cms\Http\Data\Forms\Inputs;

#region USE

use Narsil\Base\Http\Data\Forms\InputData;
use Narsil\Base\Http\Data\OptionData;
use Narsil\Base\Interfaces\Searchable;
use Narsil\Cms\Models\Sites\SitePage;

#endregionx

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 *
 * @property string $defaultValue The value of the "default value" attribute.
 * @property integer[] $values The value of the "options" attribute.
 */
class LinkInputData extends InputData
{
    #region CONSTRUCTOR

    /**
     * @param string $defaultValue The value of the "default value" attribute.
     * @param integer[] $values The value of the "options" attribute.
     *
     * @return void
     */
    public function __construct(
        string $defaultValue = '',
        array $values = []
    )
    {
        $this->set(self::DEFAULT_VALUE, $defaultValue);
        $this->set(self::INITIAL_OPTIONS, $this->getOptions($values));

        parent::__construct(static::TYPE);
    }

    #endregion

    #region CONSTANTS

    /**
     * The name of the "initial options" attribute.
     *
     * @var string
     */
    final public const INITIAL_OPTIONS = 'initialOptions';

    /**
     * The name of the "type" attribute.
     *
     * @var string
     */
    final public const TYPE = 'link';

    #endregion

    #region PROTECTED METHODS

    protected function getOptions(array $values): array
    {
        return SitePage::query()
            ->whereIn(SitePage::ID, $values)
            ->get()
            ->map(function (SitePage $sitePage)
            {
                return new OptionData(
                    label: $sitePage->{SitePage::SLUG},
                    value: $sitePage->{SitePage::ID},
                );
            })
            ->toArray();
    }

    #endregion
}
