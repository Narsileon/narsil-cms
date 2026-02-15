<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Base\Services\RouteService;
use Narsil\Cms\Contracts\Forms\AssetForm as Contract;
use Narsil\Cms\Implementations\AbstractForm;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Storages\Asset;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class AssetForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     *
     * @param string $disk
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model);

        $this->routes(RouteService::getNames(Asset::TABLE));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getTabs(): array
    {
        return [
            [
                TemplateTab::HANDLE => 'definition',
                TemplateTab::LABEL => trans('narsil-cms::ui.definition'),
                TemplateTab::RELATION_ELEMENTS => [],
            ],
        ];
    }

    #endregion
}
