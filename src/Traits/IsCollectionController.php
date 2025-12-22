<?php

namespace Narsil\Traits;

#region USE

use Narsil\Models\Entities\Entity;
use Narsil\Services\CollectionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
trait IsCollectionController
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $collection = request()->route('collection');

        $template = CollectionService::getTemplate($collection);

        if ($template)
        {
            Entity::setTemplate($template);
        }
        else
        {
            abort(404);
        }
    }

    #endregion
}
