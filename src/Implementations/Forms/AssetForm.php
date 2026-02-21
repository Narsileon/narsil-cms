<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Base\Http\Data\Forms\FormStepData;
use Narsil\Base\Implementations\Form;
use Narsil\Base\Services\RouteService;
use Narsil\Cms\Contracts\Forms\AssetForm as Contract;
use Narsil\Cms\Models\Storages\Asset;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class AssetForm extends Form implements Contract
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
    protected function getSteps(): array
    {
        return [
            new FormStepData(),
        ];
    }

    #endregion
}
