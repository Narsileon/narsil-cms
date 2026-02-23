<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Base\Http\Data\Forms\FieldData;
use Narsil\Cms\Http\Data\Forms\FormStepData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Base\Implementations\Form;
use Narsil\Base\Services\RouteService;
use Narsil\Cms\Contracts\Forms\EntityForm as Contract;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Entities\Entity;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityForm extends Form implements Contract
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     *
     * @param Template $template
     */
    public function __construct(Template $template, ?Model $model = null)
    {
        $this->template = $template;

        parent::__construct($model);

        $this->routes(RouteService::getNames('collections', [
            'collection' => $template->{Template::TABLE_NAME},
        ]));
    }

    #endregion

    #region PROPERTIES

    /**
     * @var Template
     */
    protected Template $template;

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getSteps(): array
    {
        $steps = $this->template->{Template::RELATION_TABS}->map(function ($templateTab)
        {
            return FormStepData::fromModel($templateTab);
        })->toArray();

        $steps[] = [
            new FormStepData(
                id: 'sidebar',
                elements: [
                    new FieldData(
                        id: Entity::SLUG,
                        required: true,
                        translatable: true,
                        input: new TextInputData(),
                    ),
                ],
            ),
        ];

        return $steps;
    }

    #endregion
}
