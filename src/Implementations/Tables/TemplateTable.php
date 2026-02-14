<?php

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Base\Enums\PostgreTypeEnum;
use Narsil\Cms\Implementations\AbstractTable;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Services\ModelService;
use Narsil\Cms\Support\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateTable extends AbstractTable
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Template::TABLE);
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
                id: Template::ID,
                visibility: true,
            ),
            new TableColumn(
                id: Template::TABLE_NAME,
                visibility: true,
            ),
            new TableColumn(
                id: Template::SINGULAR,
                visibility: true,
            ),
            new TableColumn(
                id: Template::PLURAL,
                visibility: true,
            ),
            new TableColumn(
                header: ModelService::getTableLabel(TemplateTab::TABLE),
                id: Template::COUNT_TABS,
                type: PostgreTypeEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                id: Template::CREATED_AT,
                visibility: true,
            ),
            new TableColumn(
                id: Template::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
