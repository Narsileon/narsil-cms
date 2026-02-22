<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Narsil\Base\Http\Data\Forms\FieldData;
use Narsil\Base\Http\Data\Forms\FormStepData;
use Narsil\Base\Http\Data\Forms\Inputs\SelectInputData;
use Narsil\Base\Implementations\Form;
use Narsil\Cms\Contracts\Forms\SiteForm as Contract;
use Narsil\Cms\Http\Data\Forms\Inputs\TreeInputData;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\Header;
use Narsil\Cms\Models\Sites\Site;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteForm extends Form implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getSteps(): array
    {
        return [
            new FormStepData(
                id: Site::RELATION_PAGES,
                label: trans('narsil-cms::ui.navigation'),
                elements: [
                    new FieldData(
                        id: Site::HEADER_ID,
                        input: new SelectInputData(
                            options: Header::options(),
                        ),
                    ),
                    new FieldData(
                        id: Site::FOOTER_ID,
                        input: new SelectInputData(
                            options: Footer::options(),
                        ),
                    ),
                    new FieldData(
                        id: Site::RELATION_PAGES,
                        label: trans('narsil-cms::ui.navigation'),
                        input: new TreeInputData(),
                    ),
                ],
            ),
        ];
    }

    #endregion
}
