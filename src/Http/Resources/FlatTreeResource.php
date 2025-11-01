<?php

namespace Narsil\Http\Resources;

#region USE

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Narsil\Models\TreeModel;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FlatTreeResource extends JsonResource
{
    #region CONSTANTS

    /**
     * The name of the "badge" property.
     *
     * @var string
     */
    final public const BADGE = 'badge';

    /**
     * The name of the "create_url" property.
     *
     * @var string
     */
    final public const CREATE_URL = 'create_url';

    /**
     * The name of the "edit_url" property.
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

            TreeModel::ATTRIBUTE_DEPTH => $this->{TreeModel::ATTRIBUTE_DEPTH},

            TreeModel::COUNT_CHILDREN => $this->{TreeModel::COUNT_CHILDREN},
        ];
    }

    #endregion
}
