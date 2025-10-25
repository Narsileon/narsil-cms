<?php

namespace Narsil\Http\Controllers\GraphQL;

#region USE

use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Http\Controllers\AbstractController;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class GraphiQLController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $title = 'GraphiQL';
        $description = 'GraphiQL';

        return $this->render(
            component: 'narsil/cms::graphiql/index',
            title: $title,
            description: $description,
        );
    }

    #endregion
}
