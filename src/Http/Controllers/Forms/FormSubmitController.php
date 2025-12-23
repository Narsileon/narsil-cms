<?php

namespace Narsil\Http\Controllers\Forms;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Forms\Form;
use Narsil\Models\Forms\FormSubmission;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormSubmitController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request, Form $form): JsonResponse
    {
        $data = $request->all();

        FormSubmission::create([
            FormSubmission::DATA => $data,
            FormSubmission::FORM_ID => $form->{Form::ID},
        ]);

        return response()->json([
            'success' => true,
        ]);
    }

    #endregion
}
