<?php

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Base\Http\Data\Forms\Inputs\DatetimeInputData;
use Narsil\Base\Http\Data\Forms\Inputs\NumberInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Base\Http\Data\TanStackTables\ColumnDefData;
use Narsil\Base\Implementations\Table;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\FooterLink;
use Narsil\Cms\Models\Globals\FooterSocialMedium;
use Narsil\Cms\Models\Sites\Site;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterTable extends Table
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Footer::TABLE);
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function columns(): array
    {
        return [
            new ColumnDefData(
                id: Footer::ID,
                type: NumberInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                id: Footer::SLUG,
                type: TextInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                id: Footer::ORGANIZATION,
                type: TextInputData::TYPE,
            ),
            new ColumnDefData(
                id: Footer::EMAIL,
                type: TextInputData::TYPE,
            ),
            new ColumnDefData(
                id: Footer::PHONE,
                type: TextInputData::TYPE,
            ),
            new ColumnDefData(
                id: Footer::STREET,
                type: TextInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                id: Footer::POSTAL_CODE,
                type: TextInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                id: Footer::CITY,
                type: TextInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                id: Footer::COUNTRY,
                type: TextInputData::TYPE,
            ),
            new ColumnDefData(
                id: Footer::ORGANIZATION_SCHEMA,
                type: TextInputData::TYPE,
            ),
            new ColumnDefData(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(Site::VIRTUAL_TABLE),
                id: Footer::COUNT_WEBSITES,
                type: NumberInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(FooterLink::TABLE),
                id: Footer::COUNT_LINKS,
                type: NumberInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(FooterSocialMedium::TABLE),
                id: Footer::COUNT_SOCIAL_MEDIA,
                type: NumberInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                id: Footer::CREATED_AT,
                type: DatetimeInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                id: Footer::UPDATED_AT,
                type: DatetimeInputData::TYPE,
                visibility: true,
            ),
        ];
    }

    #endregion
}
