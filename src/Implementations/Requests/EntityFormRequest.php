<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\EntityFormRequest as Contract;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Structures\Template;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityFormRequest implements Contract
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
        $rules = [
            Entity::PUBLISHED_FROM => [
                FormRule::DATE,
                FormRule::SOMETIMES,
                FormRule::NULLABLE,
            ],
            Entity::PUBLISHED_TO => [
                FormRule::DATE,
                FormRule::SOMETIMES,
                FormRule::NULLABLE,
            ],
            Entity::SLUG => [
                FormRule::ARRAY,
                FormRule::REQUIRED,
            ],
        ];

        return $rules;
    }

    #endregion
}
