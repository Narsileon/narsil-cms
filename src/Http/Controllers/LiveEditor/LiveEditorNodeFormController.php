<?php

namespace Narsil\Cms\Http\Controllers\LiveEditor;

#region USE

use Illuminate\Http\JsonResponse;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Http\Controllers\RedirectController;
use Narsil\Cms\Http\Resources\LiveEditor\EntityNodeInspectorResource;
use Narsil\Cms\Models\Entities\EntityNode;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Traits\IsLiveEditorController;

#endregion

/**
 * @author Jonathan Rigaux
 */
class LiveEditorNodeFormController extends RedirectController
{
    use IsLiveEditorController;

    #region PUBLIC METHODS

    /**
     * @param SitePage $sitePage
     * @param string $nodeUuid
     *
     * @return JsonResponse
     */
    public function __invoke(SitePage $sitePage, string $nodeUuid): JsonResponse
    {
        $this->authorize(AbilityEnum::UPDATE, $sitePage);

        $entity = $this->getEntity($sitePage);

        $node = $this->getNode($entity, $nodeUuid);

        if (!$node->{EntityNode::BLOCK_ID})
        {
            abort(422, 'Only blocks can be inspected.');
        }

        $updateUrl = route('live-editor.nodes.update', [
            'nodeUuid' => $nodeUuid,
            'sitePage' => $sitePage->{SitePage::ID},
        ]);

        return response()->json(
            new EntityNodeInspectorResource($node, $entity, $updateUrl)->toArray(request())
        );
    }

    #endregion
}
