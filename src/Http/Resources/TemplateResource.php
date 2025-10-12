<?php

namespace Narsil\Http\Resources;

#region USE

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Narsil\Models\Elements\Template;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class TemplateResource extends JsonResource
{
    #region CONSTRUCTOR

    /**
     * @param Template $resource
     *
     * @return void
     */
    public function __construct(Template $resource)
    {
        parent::__construct($resource);
    }

    #endregion

    #region PROPERTIES

    /**
     * {@inheritDoc}
     */
    public static $wrap = false;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return [
            Template::ID => $this->{Template::ID},
            Template::HANDLE => $this->{Template::HANDLE},
            Template::NAME => $this->{Template::NAME},
        ];
    }

    #endregion
}
