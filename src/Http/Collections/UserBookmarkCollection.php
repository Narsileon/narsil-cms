<?php

namespace Narsil\Http\Collections;

#region USE

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;
use Narsil\Implementations\Forms\UserBookmarkForm;
use Narsil\Models\Users\UserBookmark;
use Narsil\Services\ModelService;

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
                UserBookmark::ID => $item->{UserBookmark::ID},
                UserBookmark::NAME => $item->{UserBookmark::NAME},
                UserBookmark::URL => $item->{UserBookmark::URL},
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
                'bookmarks.instruction' => trans('narsil::bookmarks.instruction'),
                'ui.add' => trans('narsil::ui.add'),
                'ui.bookmarks' => ModelService::getTableLabel(UserBookmark::TABLE),
                'ui.cancel' => trans('narsil::ui.cancel'),
                'ui.edit' => trans('narsil::ui.edit'),
                'ui.remove' => trans('narsil::ui.remove'),
            ],
        ];
    }

    #endregion
}
