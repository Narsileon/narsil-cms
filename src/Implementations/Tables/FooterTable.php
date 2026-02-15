<?php

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Base\Enums\InputTypeEnum;
use Narsil\Base\Http\Data\TanStackTables\ColumnDefData;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Implementations\AbstractTable;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\FooterLink;
use Narsil\Cms\Models\Globals\FooterSocialMedium;
use Narsil\Cms\Models\Sites\Site;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterTable extends AbstractTable
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

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function columns(): array
    {
        return [
            new ColumnDefData(
                id: Footer::ID,
                type: InputTypeEnum::NUMBER,
                visibility: true,
            ),
            new ColumnDefData(
                id: Footer::SLUG,
                type: InputTypeEnum::TEXT,
                visibility: true,
            ),
            new ColumnDefData(
                id: Footer::ORGANIZATION,
                type: InputTypeEnum::TEXT,
            ),
            new ColumnDefData(
                id: Footer::EMAIL,
                type: InputTypeEnum::TEXT,
            ),
            new ColumnDefData(
                id: Footer::PHONE,
                type: InputTypeEnum::TEXT,
            ),
            new ColumnDefData(
                id: Footer::STREET,
                type: InputTypeEnum::TEXT,
                visibility: true,
            ),
            new ColumnDefData(
                id: Footer::POSTAL_CODE,
                type: InputTypeEnum::TEXT,
                visibility: true,
            ),
            new ColumnDefData(
                id: Footer::CITY,
                type: InputTypeEnum::TEXT,
                visibility: true,
            ),
            new ColumnDefData(
                id: Footer::COUNTRY,
                type: InputTypeEnum::TEXT,
            ),
            new ColumnDefData(
                id: Footer::ORGANIZATION_SCHEMA,
                type: InputTypeEnum::TEXT,
            ),
            new ColumnDefData(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(Site::VIRTUAL_TABLE),
                id: Footer::COUNT_WEBSITES,
                type: InputTypeEnum::NUMBER,
                visibility: true,
            ),
            new ColumnDefData(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(FooterLink::TABLE),
                id: Footer::COUNT_LINKS,
                type: InputTypeEnum::NUMBER,
                visibility: true,
            ),
            new ColumnDefData(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(FooterSocialMedium::TABLE),
                id: Footer::COUNT_SOCIAL_MEDIA,
                type: InputTypeEnum::NUMBER,
                visibility: true,
            ),
            new ColumnDefData(
                id: Footer::CREATED_AT,
                type: InputTypeEnum::DATETIME,
                visibility: true,
            ),
            new ColumnDefData(
                id: Footer::UPDATED_AT,
                type: InputTypeEnum::DATETIME,
                visibility: true,
            ),
        ];
    }

    #endregion
}
