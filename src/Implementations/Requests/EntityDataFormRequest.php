<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\EntityDataFormRequest as Contract;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\Template;
use Narsil\Services\CollectionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityDataFormRequest implements Contract
{
    #region CONSTRUCTOR

    /**
     * @param Template $template
     *
     * @return void
     */
    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var Template
     */
    protected readonly Template $template;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(?Model $model = null): array
    {
        $fields = CollectionService::getTemplateFields($this->template);

        $rules = [];

        foreach ($fields as $field)
        {
            $rules[$field->{Field::HANDLE}] = [];
        }

        return $rules;
    }

    #endregion
}
