<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Base\Http\Data\TanStackTables\Columns\DateTimeColumn;
use Narsil\Base\Http\Data\TanStackTables\Columns\NumberColumn;
use Narsil\Base\Http\Data\TanStackTables\Columns\TextColumn;
use Narsil\Base\Implementations\Table;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\FooterLink;
use Narsil\Cms\Models\Globals\FooterSocialMedium;
use Narsil\Cms\Models\Sites\Site;

#endregion

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
            NumberColumn::make(
                id: Footer::ID,
                visibility: true,
            ),
            TextColumn::make(
                id: Footer::SLUG,
                visibility: true,
            ),
            TextColumn::make(
                id: Footer::ORGANIZATION,
            ),
            TextColumn::make(
                id: Footer::EMAIL,
            ),
            TextColumn::make(
                id: Footer::PHONE,
            ),
            TextColumn::make(
                id: Footer::STREET,
                visibility: true,
            ),
            TextColumn::make(
                id: Footer::POSTAL_CODE,
                visibility: true,
            ),
            TextColumn::make(
                id: Footer::CITY,
                visibility: true,
            ),
            TextColumn::make(
                id: Footer::COUNTRY,
            ),
            TextColumn::make(
                id: Footer::ORGANIZATION_SCHEMA,
            ),
            NumberColumn::make(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(Site::VIRTUAL_TABLE),
                id: Footer::COUNT_WEBSITES,
                visibility: true,
            ),
            NumberColumn::make(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(FooterLink::TABLE),
                id: Footer::COUNT_LINKS,
                visibility: true,
            ),
            NumberColumn::make(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(FooterSocialMedium::TABLE),
                id: Footer::COUNT_SOCIAL_MEDIA,
                visibility: true,
            ),
            DateTimeColumn::make(
                id: Footer::CREATED_AT,
                visibility: true,
            ),
            DateTimeColumn::make(
                id: Footer::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
