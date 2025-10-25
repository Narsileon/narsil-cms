<?php

namespace Narsil\Http\Controllers;

#region USE

use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Entities\Entity;
use Narsil\Services\TemplateService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractEntityController extends AbstractController
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $collection = request()->route('collection');

        $template = TemplateService::getTemplate($collection);

        if ($template)
        {
            Entity::setTemplate($template);
        }
    }

    #endregion
}
