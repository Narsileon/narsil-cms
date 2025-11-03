<?php

namespace Narsil\Http\Controllers\HostPages;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\HostPageForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Hosts\HostPage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostPageCreateController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param string $site
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, string $site): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::CREATE, HostPage::class);

        $data = $request->query();
        $form = $this->getForm($site)
            ->formData($data);

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
        );
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the associated form.
     *
     * @param string $site
     *
     * @return HostPageForm
     */
    protected function getForm(string $site): HostPageForm
    {
        $form = app(HostPageForm::class)
            ->action(route('sites.pages.store', [
                'site' => $site,
            ]))
            ->method(MethodEnum::POST->value)
            ->submitLabel(trans('narsil::ui.save'));

        return $form;
    }

    #endregion
}
