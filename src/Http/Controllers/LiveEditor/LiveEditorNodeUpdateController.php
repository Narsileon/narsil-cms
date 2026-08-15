<?php

declare(strict_types=1);

namespace Narsil\Cms\Http\Controllers\LiveEditor;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Http\Controllers\RedirectController;
use Narsil\Cms\Contracts\Actions\LiveEditor\UpdateEntityNode;
use Narsil\Cms\Models\Entities\EntityNode;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Traits\IsLiveEditorController;

#endregion

class LiveEditorNodeUpdateController extends RedirectController
{
    use IsLiveEditorController;

    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param SitePage $sitePage
     * @param string $nodeUuid
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request, SitePage $sitePage, string $nodeUuid): JsonResponse
    {
        $this->authorize(AbilityEnum::UPDATE, $sitePage);

        $entity = $this->getEntity($sitePage);

        $node = $this->getNode($entity, $nodeUuid);

        if (!$node->{EntityNode::BLOCK_ID})
        {
            abort(422, 'Only blocks can be updated.');
        }

        $attributes = $request->except([
            self::BACK,
            self::TO,
            '_method',
        ]);

        app(UpdateEntityNode::class)->run($node, $attributes);

        return response()->json([
            'tree' => $this->getTree($sitePage),
        ]);
    }

    #endregion
}
