<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Base\Http\Data\Forms\FieldData;
use Narsil\Base\Http\Data\Forms\FormStepData;
use Narsil\Base\Http\Data\Forms\Inputs\SelectInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Base\Http\Data\OptionData;
use Narsil\Base\Implementations\Form;
use Narsil\Base\Services\RouteService;
use Narsil\Cms\Contracts\Forms\RedirectForm as Contract;
use Narsil\Cms\Models\Redirect;

#endregion

class RedirectForm extends Form implements Contract
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model);

        $this->routes(RouteService::getNames(Redirect::TABLE));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getSteps(): array
    {
        return [
            new FormStepData(
                id: 'definition',
                label: trans('narsil-cms::ui.definition'),
                elements: [
                    new FieldData(
                        id: Redirect::URL_SOURCE,
                        required: true,
                        width: 50,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        id: Redirect::URL_DESTINATION,
                        required: true,
                        width: 50,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        id: Redirect::STATUS_CODE,
                        required: true,
                        input: new SelectInputData(
                            options: [
                                new OptionData('301 - Moved permanently', 301),
                                new OptionData('302 - Found', 302),
                                new OptionData('307 - Temporary redirect', 307),
                                new OptionData('308 - Permanent redirect', 308),
                            ],
                        ),
                    ),
                ],
            ),
        ];
    }

    #endregion
}
