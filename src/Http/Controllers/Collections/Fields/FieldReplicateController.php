<?php

namespace Narsil\Cms\Http\Controllers\Collections\Fields;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Services\FieldService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldReplicateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Field $field
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, Field $field): RedirectResponse
    {
        $this->authorize(AbilityEnum::CREATE, Field::class);

        FieldService::replicate($field);

        return back()
            ->with('success', ModelService::getSuccessMessage(Field::TABLE, ModelEventEnum::REPLICATED));
    }

    #endregion
}
