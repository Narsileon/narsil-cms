<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Base\Http\Data\Forms\Inputs\FileInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Base\Implementations\Form;
use Narsil\Base\Services\RouteService;
use Narsil\Cms\Contracts\Forms\HeaderForm as Contract;
use Narsil\Cms\Http\Data\Forms\FieldData;
use Narsil\Cms\Http\Data\Forms\FormStepData;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\Header;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HeaderForm extends Form implements Contract
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model);

        $this->routes(RouteService::getNames(Header::TABLE));
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
                label: trans('narsil-ui::ui.definition'),
                elements: [
                    new FieldData(
                        id: Footer::SLUG,
                        required: true,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        icon: 'image',
                        id: Footer::LOGO,
                        input: new FileInputData(
                            accept: 'image/*',
                        ),
                    ),
                ],
            ),
        ];
    }

    #endregion
}
