<?php

namespace Narsil\Contracts;

#region USE

use JsonSerializable;
use Narsil\Enums\Forms\MethodEnum;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface Form extends JsonSerializable
{
    /**
     * The description of the form.
     */
    public string $description
    {
        get;
        set;
    }

    /**
     * The description of the form.
     */
    public string $id
    {
        get;
        set;
    }

    /**
     * The method of the form.
     */
    public MethodEnum $method
    {
        get;
        set;
    }

    /**
     * The label of the submit button.
     */
    public string $submitLabel
    {
        get;
        set;
    }

    /**
     * The title of the form.
     */
    public string $title
    {
        get;
        set;
    }

    /**
     * The url of the form.
     */
    public string $url
    {
        get;
        set;
    }

    #region PUBLIC METHODS

    /**
     * Define the template of the form.
     *
     * @return array
     */
    public function form(): array;

    #endregion
}
