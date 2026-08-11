<?php

namespace Narsil\Cms\Http\Controllers\LiveEditor;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Http\Controllers\RedirectController;
use Narsil\Cms\Contracts\Actions\LiveEditor\CreateEntityBlockNode;
use Narsil\Cms\Models\Entities\EntityNode;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Traits\IsLiveEditorController;

#endregion

/**
 * @author Jonathan Rigaux
 */
class LiveEditorNodeStoreController extends RedirectController
{
    use IsLiveEditorController;

    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param SitePage $sitePage
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request, SitePage $sitePage): JsonResponse
    {
        $this->authorize(AbilityEnum::UPDATE, $sitePage);

        $attributes = $request->validate([
            'blockId' => ['required', 'integer'],
            'parentUuid' => ['required', 'string'],
            'position' => ['nullable', 'integer', 'min:0'],
        ]);

        $entity = $this->getEntity($sitePage);

        $parent = $this->getNode($entity, $attributes['parentUuid']);

        if ($parent->{EntityNode::BLOCK_ID})
        {
            abort(422, 'Blocks can only be added to a builder.');
        }

        $node = app(CreateEntityBlockNode::class)->run(
            $parent,
            $attributes['blockId'],
            $attributes['position'] ?? null,
        );

        return response()->json([
            'nodeUuid' => $node->{EntityNode::UUID},
            'tree' => $this->getTree($sitePage),
        ]);
    }

    #endregion
}
