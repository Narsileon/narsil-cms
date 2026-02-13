<?php

namespace Narsil\Cms\Http\Controllers\Hosts;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Cms\Casts\HumanDatetimeCast;
use Narsil\Cms\Contracts\Forms\HostForm;
use Narsil\Cms\Enums\RequestMethodEnum;
use Narsil\Cms\Http\Controllers\RenderController;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Hosts\HostLocale;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostEditController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Host $host
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, Host $host): JsonResponse|Response
    {
        $this->authorize(AbilityEnum::UPDATE, $host);

        $host->loadMissing([
            Host::RELATION_DEFAULT_LOCALE,
            Host::RELATION_DEFAULT_LOCALE . '.' . HostLocale::RELATION_LANGUAGES,
            Host::RELATION_OTHER_LOCALES,
            Host::RELATION_OTHER_LOCALES . '.' . HostLocale::RELATION_LANGUAGES
        ]);

        $data = $this->getData($host);
        $form = $this->getForm($host);

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
     * @param Host $host
     *
     * @return array<string,mixed>
     */
    protected function getData(Host $host): array
    {
        $host->loadMissingCreatorAndEditor();

        $host->mergeCasts([
            Host::CREATED_AT => HumanDatetimeCast::class,
            Host::UPDATED_AT => HumanDatetimeCast::class,
        ]);

        $data = $host->toArrayWithTranslations();

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return ModelService::getModelLabel(Host::TABLE);
    }

    /**
     * Get the associated form.
     *
     * @param Host $host
     *
     * @return HostForm
     */
    protected function getForm(Host $host): HostForm
    {
        $form = app(HostForm::class, ['model' => $host])
            ->action(route('hosts.update', $host->{Host::ID}))
            ->id($host->{Host::ID})
            ->method(RequestMethodEnum::PATCH->value)
            ->submitLabel(trans('narsil-cms::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getModelLabel(Host::TABLE);
    }

    #endregion
}
