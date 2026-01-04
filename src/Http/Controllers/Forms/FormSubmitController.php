<?php

namespace Narsil\Http\Controllers\Forms;

#region USE

use Illuminate\Http\RedirectResponse;
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
     * @return RedirectResponse
     */
    public function __invoke(Request $request, Form $form): RedirectResponse
    {
        $data = $request->all();

        FormSubmission::create([
            FormSubmission::DATA => $data,
            FormSubmission::FORM_ID => $form->{Form::ID},
        ]);

        return back()
            ->with('success', true);
    }

    #endregion
}
