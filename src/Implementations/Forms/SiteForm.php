<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Narsil\Base\Http\Data\Forms\FieldData;
use Narsil\Base\Http\Data\Forms\FormStepData;
use Narsil\Base\Http\Data\Forms\Inputs\SelectInputData;
use Narsil\Base\Implementations\Form;
use Narsil\Base\Services\FormService;
use Narsil\Cms\Contracts\Forms\SiteForm as Contract;
use Narsil\Cms\Http\Data\Forms\Inputs\TreeInputData;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\Header;
use Narsil\Cms\Models\Sites\Site;

#endregion

/**
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
        $footerOptions = FormService::getOptions(Footer::class);
        $headerOptions = FormService::getOptions(Header::class);

        return [
            new FormStepData(
                id: Site::RELATION_PAGES,
                label: trans('narsil-cms::ui.navigation'),
                elements: [
                    new FieldData(
                        id: Site::HEADER_ID,
                        input: new SelectInputData(
                            options: $headerOptions->toArray(),
                        ),
                    ),
                    new FieldData(
                        id: Site::FOOTER_ID,
                        input: new SelectInputData(
                            options: $footerOptions->toArray(),
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
