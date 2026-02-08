<?php

namespace Narsil\Cms\Http\Collections;

#region USE

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;
use Narsil\Cms\Implementations\Forms\UserBookmarkForm;
use Narsil\Cms\Models\Users\UserBookmark;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserBookmarkCollection extends ResourceCollection
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): JsonSerializable
    {
        return $this->collection->map(function ($item)
        {
            return [
                UserBookmark::NAME => $item->{UserBookmark::NAME},
                UserBookmark::URL => $item->{UserBookmark::URL},
                UserBookmark::UUID => $item->{UserBookmark::UUID},
            ];
        });
    }

    /**
     * {@inheritDoc}
     */
    public function with($request): array
    {
        return [
            'meta' => $this->getMeta(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<string,mixed>
     */
    protected function getMeta(): array
    {
        return [
            'form' => app(UserBookmarkForm::class),
            'translations' => [
                'bookmarks.instruction' => trans('narsil-cms::bookmarks.instruction'),
                'ui.add' => trans('narsil-cms::ui.add'),
                'ui.bookmarks' => ModelService::getTableLabel(UserBookmark::TABLE),
                'ui.cancel' => trans('narsil-ui::ui.cancel'),
                'ui.edit' => trans('narsil-cms::ui.edit'),
                'ui.remove' => trans('narsil-cms::ui.remove'),
            ],
        ];
    }

    #endregion
}
