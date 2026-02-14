<?php

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Base\Enums\PostgreTypeEnum;
use Narsil\Cms\Implementations\AbstractTable;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Hosts\HostLocale;
use Narsil\Cms\Models\Hosts\HostLocaleLanguage;
use Narsil\Cms\Services\ModelService;
use Narsil\Cms\Support\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostTable extends AbstractTable
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Host::TABLE);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function columns(): array
    {
        return [
            new TableColumn(
                id: Host::ID,
                visibility: true,
            ),
            new TableColumn(
                id: Host::HOSTNAME,
                visibility: true,
            ),
            new TableColumn(
                id: Host::LABEL,
                visibility: true,
            ),
            new TableColumn(
                header: ModelService::getTableLabel(HostLocale::TABLE),
                id: Host::COUNT_LOCALES,
                type: PostgreTypeEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                header: ModelService::getTableLabel(HostLocaleLanguage::TABLE),
                id: Host::COUNT_LANGUAGES,
                type: PostgreTypeEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                id: Host::CREATED_AT,
                visibility: true,
            ),
            new TableColumn(
                id: Host::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
