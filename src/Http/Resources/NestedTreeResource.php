<?php

namespace Narsil\Http\Resources;

#region USE

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Narsil\Models\TreeModel;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class NestedTreeResource extends JsonResource
{
    #region CONSTANTS

    /**
     * The name of the "badge" property.
     *
     * @var string
     */
    final public const BADGE = 'badge';

    /**
     * The name of the "create url" property.
     *
     * @var string
     */
    final public const CREATE_URL = 'create_url';

    /**
     * The name of the "destroy url" property.
     *
     * @var string
     */
    final public const DESTROY_URL = 'destroy_url';

    /**
     * The name of the "edit url" property.
     *
     * @var string
     */
    final public const EDIT_URL = 'edit_url';

    /**
     * The name of the "label" property.
     *
     * @var string
     */
    final public const LABEL = 'label';

    #endregion

    #region PROPERTIES

    /**
     * {@inheritDoc}
     */
    public static $wrap = null;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return [
            TreeModel::ID => $this->{TreeModel::ID},
            TreeModel::LEFT_ID => $this->{TreeModel::LEFT_ID},
            TreeModel::PARENT_ID => $this->{TreeModel::PARENT_ID},
            TreeModel::RIGHT_ID => $this->{TreeModel::RIGHT_ID},

            TreeModel::RELATION_CHILDREN => $this->getChildren($request, $this->{TreeModel::RELATION_CHILDREN}),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the children.
     *
     * @param Request $request
     * @param Collection<TreeModel> $children
     *
     * @return void
     */
    protected function getChildren(Request $request, Collection $children)
    {
        return $children->map(function ($child) use ($request)
        {
            $resource = new static($child);

            return $resource->toArray($request);
        })->toArray();
    }

    #endregion
}
