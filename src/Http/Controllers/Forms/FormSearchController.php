<?php

namespace Narsil\Http\Controllers\Forms;

#region USE

use Illuminate\Http\JsonResponse;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Http\Requests\SearchRequest;
use Narsil\Models\Forms\Form;
use Narsil\Support\SelectOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormSearchController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param SearchRequest $request
     * @param string $search
     *
     * @return JsonResponse
     */
    public function __invoke(SearchRequest $request): JsonResponse
    {
        $search = $request->validated(SearchRequest::SEARCH);

        $selectOptions = Form::query()
            ->when($search, function ($query) use ($search)
            {
                return $query
                    ->where(Form::SLUG, 'like', "%$search%");
            })
            ->get()
            ->map(function (Form $form)
            {
                return (new SelectOption())
                    ->optionLabel($form->{Form::SLUG})
                    ->optionValue($form->{Form::ID});
            })
            ->all();

        return response()
            ->json($selectOptions);
    }

    #endregion
}
