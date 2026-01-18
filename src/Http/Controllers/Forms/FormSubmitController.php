<?php

namespace Narsil\Http\Controllers\Forms;

#region USE

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\FormSubmitFormRequest;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Forms\Form;
use Narsil\Models\Forms\FormSubmission;
use Narsil\Models\Forms\FormWebhook;

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

        $rules = app(FormSubmitFormRequest::class, [
            'form' => $form,
        ])->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        FormSubmission::create([
            FormSubmission::DATA => $attributes,
            FormSubmission::FORM_ID => $form->{Form::ID},
        ]);

        $form->loadMissing([
            Form::RELATION_WEBHOOKS,
        ]);

        foreach ($form->{Form::RELATION_WEBHOOKS} as $webhook)
        {
            $url = $webhook->{FormWebhook::URL};

            try
            {
                Http::post($url, [
                    Form::SLUG => $form->{Form::SLUG},
                    FormSubmission::DATA => $attributes,
                ]);
            }
            catch (Exception $exception)
            {
                Log::error("Webhook failed: $url", [
                    'error' => $exception->getMessage(),
                ]);
            }
        }

        return back()
            ->with('success', true);
    }

    #endregion
}
