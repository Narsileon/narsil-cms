<?php

namespace Narsil\Cms\Http\Controllers\Collections\Fields;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Http\Controllers\RedirectController;
use Narsil\Base\Http\Requests\ReplicateManyRequest;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Services\FieldService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldReplicateManyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(ReplicateManyRequest $request): RedirectResponse
    {
        $this->authorize(AbilityEnum::CREATE, Field::class);

        $ids = $request->validated(ReplicateManyRequest::IDS);

        $fields = Field::query()
            ->findMany($ids);

        foreach ($fields as $field)
        {
            FieldService::replicate($field);
        }

        return back()
            ->with('success', ModelService::getSuccessMessage(Field::TABLE, ModelEventEnum::REPLICATED_MANY));
    }

    #endregion
}
