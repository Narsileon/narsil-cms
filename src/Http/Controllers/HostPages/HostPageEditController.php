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
class HostPageEditController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param HostPage $hostPage
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, string $site, HostPage $hostPage): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $hostPage);

        $data = $this->getData($hostPage);
        $form = $this->getForm($site, $hostPage)
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
     * @param HostPage $hostPage
     *
     * @return array<string,mixed>
     */
    protected function getData(HostPage $hostPage): array
    {
        $data = $hostPage->toArrayWithTranslations();

        return $data;
    }

    /**
     * Get the associated form.
     *
     * @param string $site
     * @param HostPage $hostPage
     *
     * @return HostPageForm
     */
    protected function getForm(string $site, HostPage $hostPage): HostPageForm
    {
        $form = app(HostPageForm::class)
            ->action(route('sites.pages.update', [
                'hostPage' => $hostPage->{HostPage::ID},
                'site' => $site,
            ]))
            ->id($hostPage->{HostPage::ID})
            ->method(MethodEnum::PATCH->value)
            ->submitLabel(trans('narsil::ui.update'));

        return $form;
    }

    #endregion
}
