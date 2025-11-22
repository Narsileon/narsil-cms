<?php

namespace Narsil\Http\Controllers\Configurations;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\ConfigurationForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Configuration;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ConfigurationEditController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $configuration = Configuration::firstOrCreate();

        $data = $this->getData($configuration);
        $form = $this->getForm($configuration);

        return $this->render('narsil/cms::settings/form', [
            'data' => $data,
            'form' => $form,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the associated data.
     *
     * @param Configuration $configuration
     *
     * @return array<string,mixed>
     */
    protected function getData(Configuration $configuration): array
    {
        $data = $configuration->toArray();

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return trans('narsil::ui.settings');
    }

    /**
     * Get the associated form.
     *
     * @param Configuration $configuration
     *
     * @return ConfigurationForm
     */
    protected function getForm(Configuration $configuration): ConfigurationForm
    {
        $form = app(ConfigurationForm::class)
            ->action(route('settings.update', $configuration->{Configuration::ID}))
            ->id($configuration->{Configuration::ID})
            ->method(MethodEnum::PATCH->value)
            ->submitLabel(trans('narsil::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return trans('narsil::ui.settings');
    }

    #endregion
}
