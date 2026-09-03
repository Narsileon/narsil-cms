<?php

declare(strict_types=1);

namespace Narsil\Cms\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Narsil\Base\Http\Controllers\RenderController;

#endregion

class DashboardController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|View
     */
    public function __invoke(Request $request): JsonResponse|View
    {
        return $this->renderBlade('narsil-cms::index');
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return trans('narsil-cms::ui.dashboard');
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return trans('narsil-cms::ui.dashboard');
    }

    #endregion
}
