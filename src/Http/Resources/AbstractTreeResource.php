<?php

namespace Narsil\Http\Resources;

#region USE

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Narsil\Models\TreeModel;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class AbstractTreeResource extends JsonResource
{
    #region CONSTANTS

    /**
     * @var string
     */
    final public const CREATE_URL = 'create_url';

    /**
     * @var string
     */
    final public const EDIT_URL = 'edit_url';

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

            TreeModel::RELATION_CHILDREN => static::collection($this->{TreeModel::RELATION_CHILDREN})->toArray($request),
        ];
    }

    #endregion
}
