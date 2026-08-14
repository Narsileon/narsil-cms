<?php

namespace Narsil\Cms\Http\Controllers\LiveEditor;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Http\Controllers\RedirectController;
use Narsil\Cms\Contracts\Actions\LiveEditor\ReorderEntityNodes;
use Narsil\Cms\Models\Entities\EntityNode;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Traits\IsLiveEditorController;

#endregion

class LiveEditorNodeReorderController extends RedirectController
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
            'parentUuid' => ['required', 'string'],
            'uuids' => ['present', 'array'],
            'uuids.*' => ['string'],
        ]);

        $entity = $this->getEntity($sitePage);

        $parent = $this->getNode($entity, $attributes['parentUuid']);

        if ($parent->{EntityNode::BLOCK_ID})
        {
            abort(422, 'Only the blocks of a builder can be reordered.');
        }

        app(ReorderEntityNodes::class)->run($parent, $attributes['uuids']);

        return response()->json([
            'tree' => $this->getTree($sitePage),
        ]);
    }

    #endregion
}
