<?php

namespace Narsil\Http\Controllers\Hosts;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Casts\HumanDatetimeCast;
use Narsil\Contracts\Forms\HostForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostEditController extends AbstractController
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
        $this->authorize(PermissionEnum::UPDATE, $host);

        $host->loadMissing([
            Host::RELATION_DEFAULT_LOCALE,
            Host::RELATION_DEFAULT_LOCALE . '.' . HostLocale::RELATION_LANGUAGES,
            Host::RELATION_OTHER_LOCALES,
            Host::RELATION_OTHER_LOCALES . '.' . HostLocale::RELATION_LANGUAGES
        ]);

        $data = $this->getData($host);
        $form = $this->getForm($host)
            ->formData($data);

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
        );
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
     * Get the associated form.
     *
     * @param Host $host
     *
     * @return HostForm
     */
    protected function getForm(Host $host): HostForm
    {
        $form = app(HostForm::class)
            ->action(route('hosts.update', $host->{Host::ID}))
            ->id($host->{Host::ID})
            ->method(MethodEnum::PATCH->value)
            ->submitLabel(trans('narsil::ui.update'));

        return $form;
    }

    #endregion
}
