<?php

namespace Narsil\Http\Controllers\Blocks;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\BlockForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Elements\Block;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockCreateController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::CREATE, Block::class);

        $form = $this->getForm();

        return $this->render('narsil/cms::resources/form', [
            'form' => $form,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return trans('narsil::models.' . Block::class);
    }

    /**
     * Get the associated form.
     *
     * @return BlockForm
     */
    protected function getForm(): BlockForm
    {
        $form = app(BlockForm::class)
            ->action(route('blocks.store'))
            ->method(MethodEnum::POST->value)
            ->submitLabel(trans('narsil::ui.save'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return trans('narsil::models.' . Block::class);
    }

    #endregion
}
