<?php

namespace Narsil\Cms\Http\Controllers\GraphQL;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Cms\Http\Controllers\RenderController;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class GraphiQLController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        return $this->render('narsil/cms::graphiql/index');
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return 'GraphQL';
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return 'GraphQL';
    }

    #endregion
}
