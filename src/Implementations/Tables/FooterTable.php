<?php

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Base\Enums\PostgreTypeEnum;
use Narsil\Cms\Implementations\AbstractTable;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\FooterLink;
use Narsil\Cms\Models\Globals\FooterSocialMedium;
use Narsil\Cms\Models\Sites\Site;
use Narsil\Cms\Services\ModelService;
use Narsil\Cms\Support\TableColumn;

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
            new TableColumn(
                id: Footer::ID,
                visibility: true,
            ),
            new TableColumn(
                id: Footer::SLUG,
                visibility: true,
            ),
            new TableColumn(
                id: Footer::ORGANIZATION,
                visibility: false,
            ),
            new TableColumn(
                id: Footer::EMAIL,
                visibility: false,
            ),
            new TableColumn(
                id: Footer::PHONE,
                visibility: false,
            ),
            new TableColumn(
                id: Footer::STREET,
                visibility: true,
            ),
            new TableColumn(
                id: Footer::POSTAL_CODE,
                visibility: true,
            ),
            new TableColumn(
                id: Footer::CITY,
                visibility: true,
            ),
            new TableColumn(
                id: Footer::COUNTRY,
                visibility: false,
            ),
            new TableColumn(
                id: Footer::ORGANIZATION_SCHEMA,
                visibility: false,
            ),
            new TableColumn(
                header: ModelService::getTableLabel(Site::VIRTUAL_TABLE),
                id: Footer::COUNT_WEBSITES,
                type: PostgreTypeEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                header: ModelService::getTableLabel(FooterLink::TABLE),
                id: Footer::COUNT_LINKS,
                type: PostgreTypeEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                header: ModelService::getTableLabel(FooterSocialMedium::TABLE),
                id: Footer::COUNT_SOCIAL_MEDIA,
                type: PostgreTypeEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                id: Footer::CREATED_AT,
                visibility: true,
            ),
            new TableColumn(
                id: Footer::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
