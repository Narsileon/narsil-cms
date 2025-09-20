<?php

namespace Narsil\Contracts;

#region USE

use Illuminate\Database\Eloquent\Model;
use JsonSerializable;
use Narsil\Enums\Forms\MethodEnum;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
interface Form extends JsonSerializable
{
    #region PROPERTIES

    /**
     * The action of the form.
     *
     * @var string
     */
    public string $action
    {
        get;
        set;
    }

    /**
     * The data of the form.
     *
     * @var Model|array<string,mixed>
     */
    public Model|array $data
    {
        get;
        set;
    }

    /**
     * The description of the form.
     *
     * @var string
     */
    public string $description
    {
        get;
        set;
    }

    /**
     * The id of the model.
     *
     * @var mixed
     */
    public mixed $id
    {
        get;
        set;
    }

    /**
     * The method of the form.
     *
     * @var MethodEnum
     */
    public MethodEnum $method
    {
        get;
        set;
    }

    /**
     * The icon of the submit.
     *
     * @var string|null
     */
    public ?string $submitIcon
    {
        get;
        set;
    }

    /**
     * The label of the submit.
     *
     * @var string
     */
    public string $submitLabel
    {
        get;
        set;
    }

    /**
     * The title of the form.
     *
     * @var string
     */
    public string $title
    {
        get;
        set;
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * Define the layout of the form.
     *
     * @return array
     */
    public function layout(): array;

    #endregion
}
