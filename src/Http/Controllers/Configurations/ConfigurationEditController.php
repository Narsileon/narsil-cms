<?php

namespace Narsil\Cms\Http\Controllers\Configurations;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Cms\Casts\HumanDatetimeCast;
use Narsil\Cms\Contracts\Forms\ConfigurationForm;
use Narsil\Cms\Enums\RequestMethodEnum;
use Narsil\Cms\Http\Controllers\RenderController;
use Narsil\Cms\Models\Configuration;
use Narsil\Cms\Services\ModelService;

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

        return $this->render('narsil/cms::resources/form', [
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
        $configuration->loadMissingCreatorAndEditor();

        $configuration->mergeCasts([
            Configuration::CREATED_AT => HumanDatetimeCast::class,
            Configuration::UPDATED_AT => HumanDatetimeCast::class,
        ]);

        $data = $configuration->toArrayWithTranslations();

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return ModelService::getModelLabel(Configuration::class);
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
            ->method(RequestMethodEnum::PATCH->value)
            ->submitLabel(trans('narsil::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getModelLabel(Configuration::class);
    }

    #endregion
}
