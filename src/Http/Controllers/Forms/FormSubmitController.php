<?php

namespace Narsil\Http\Controllers\Forms;

#region USE

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\FormSubmissionDataFormRequest;
use Narsil\Contracts\FormRequests\FormSubmissionFormRequest;
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
        $attributes = $this->validateSubmission($request);

        $step = Arr::get($attributes, FormSubmissionFormRequest::STEP);
        $uuid = Arr::get($attributes, FormSubmissionFormRequest::UUID);

        $data = $this->validateSubmissionData($request, $form, $step);

        $submission = FormSubmission::updateOrCreate([
            FormSubmission::FORM_ID => $form->{Form::ID},
            FormSubmission::UUID => $uuid,
        ], [
            FormSubmission::DATA => $data,
        ]);

        if ($step === null || $step === count($form->{Form::RELATION_STEPS}) - 1)
        {
            $this->sendToWebhooks($form, $submission);
        }

        return back()->with([
            'success' => true,
            'uuid' => $submission->uuid,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Form $form
     * @param FormSubmission $formSubmission
     *
     * @return void
     */
    protected function sendToWebhooks(Form $form, FormSubmission $formSubmission): void
    {
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
                    FormSubmission::DATA => $formSubmission->{FormSubmission::DATA},
                ]);
            }
            catch (Exception $exception)
            {
                Log::error("Webhook failed: $url", [
                    'error' => $exception->getMessage(),
                ]);
            }
        }
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    protected function validateSubmission(Request $request): array
    {
        $data = $request->all();

        $rules = app(FormSubmissionFormRequest::class)
            ->rules();

        return Validator::make($data, $rules)
            ->validated();
    }

    /**
     * @param Request $request
     * @param Form $form
     * @param integer $step
     *
     * @return array
     */
    protected function validateSubmissionData(Request $request, Form $form, int $step): array
    {
        $data = $request->all();

        $rules = app(FormSubmissionDataFormRequest::class, [
            'form' => $form,
            'step' => $step,
        ])->rules();

        return Validator::make($data, $rules)
            ->validated();
    }

    #endregion
}
