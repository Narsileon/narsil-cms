<?php

namespace Narsil\Cms\Traits;

#region USE

use Narsil\Cms\Models\Collections\Template;

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
            ->firstWhere(Template::TABLE_NAME, '=', $collection);

        if ($template)
        {
            $this->template = $template;
            $this->entityClass = $template->entityClass();
        }
        else
        {
            abort(404);
        }
    }

    #endregion

    #region PROPERTIES

    /**
     * @var Template
     */
    protected readonly Template $template;

    /**
     * @var string
     */
    protected readonly string $entityClass;

    #endregion
}
