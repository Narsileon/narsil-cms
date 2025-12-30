<?php

namespace Narsil\Traits;

#region USE

use Narsil\Models\Entities\EntityData;
use Narsil\Models\Structures\Template;
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
            $this->template = $template;

            EntityData::setTemplate($template);
        }
        else
        {
            abort(404);
        }
    }

    #endregion

    #region PROPERTIES

    protected readonly Template $template;

    #endregion
}
