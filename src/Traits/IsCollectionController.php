<?php

namespace Narsil\Traits;

#region USE

use Narsil\Models\Structures\Template;

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

        $template = Template::query()
            ->firstWhere(Template::HANDLE, '=', $collection);

        if ($template)
        {
            $this->template = $template;
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
