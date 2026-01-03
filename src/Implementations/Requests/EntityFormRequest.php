<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\Fields\BuilderField;
use Narsil\Contracts\FormRequests\EntityFormRequest as Contract;
use Narsil\Interfaces\IStructureHasElement;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\Template;
use Narsil\Models\Structures\TemplateTab;
use Narsil\Models\ValidationRule;
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

        foreach ($this->template->{Template::RELATION_TABS} as $templateTab)
        {
            $this->populateRules($rules, $templateTab->{TemplateTab::RELATION_ELEMENTS});
        }

        return $rules;
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param array &$rules
     * @param Collection $elements
     * @param string|null $path
     *
     * @return void
     */
    protected function populateRules(array &$rules, Collection $elements, ?string $path = null): void
    {
        foreach ($elements as $element)
        {
            $handle = $element->{IStructureHasElement::HANDLE};

            $key = $path ? "$path.$handle" : $handle;

            if ($element->{IStructureHasElement::ELEMENT_TYPE} === Field::TABLE)
            {
                $field = $element->{IStructureHasElement::RELATION_ELEMENT};

                $fieldRules = $field->{Field::RELATION_VALIDATION_RULES}->pluck(ValidationRule::HANDLE)->toArray();

                $fieldRules[FormRule::REQUIRED] = $element->{IStructureHasElement::REQUIRED};

                if ($field->{Field::TYPE} === BuilderField::class)
                {
                    $rules["$key.*"] = $fieldRules;

                    foreach ($field->{Field::RELATION_BLOCKS} ?? [] as $block)
                    {
                        $this->populateRules($rules, $block->{Block::RELATION_ELEMENTS}, "$key.*");
                    }
                }
                else
                {
                    $rules[$key] = $fieldRules;
                }
            }
            else
            {
                $block = $element->{IStructureHasElement::RELATION_ELEMENT};

                $nextPath = $block->{Block::VIRTUAL} ? $path : $key;

                $this->populateRules($rules, $block->{Block::RELATION_ELEMENTS}, $nextPath);
            }
        }
    }

    #endregion
}
