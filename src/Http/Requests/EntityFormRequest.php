<?php

namespace Narsil\Http\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\EntityFormRequest as Contract;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Services\TemplateService;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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
    private readonly Template $template;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(?Model $model = null): array
    {
        $fields = TemplateService::getFields($this->template);

        $rules = [];

        foreach ($fields as $field)
        {
            $rules[$field->{Field::HANDLE}] = [];
        }

        return $rules;
    }

    #endregion
}
