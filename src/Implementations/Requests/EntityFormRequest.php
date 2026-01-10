<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Narsil\Contracts\Fields\BuilderField;
use Narsil\Contracts\FormRequests\EntityFormRequest as Contract;
use Narsil\Implementations\AbstractFormRequest;
use Narsil\Interfaces\IStructureHasElement;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Collections\Block;
use Narsil\Models\Collections\Field;
use Narsil\Models\Collections\Template;
use Narsil\Models\Collections\TemplateTab;
use Narsil\Models\ValidationRule;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityFormRequest extends AbstractFormRequest implements Contract
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
    public function attributes(): array
    {
        $attributes = [];

        foreach ($this->template->{Template::RELATION_TABS} as $templateTab)
        {
            $this->populateAttributes($attributes, $templateTab->{TemplateTab::RELATION_ELEMENTS});
        }

        return $attributes;
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
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
     * @param array $attributes
     * @param Collection $elements
     * @param string|null $path
     *
     * @return void
     */
    protected function populateAttributes(array &$attributes, Collection $elements, ?string $path = null): void
    {
        foreach ($elements as $element)
        {
            $handle = $element->{IStructureHasElement::HANDLE};

            $key = $path ? "$path.$handle" : $handle;

            if ($element->{IStructureHasElement::ELEMENT_TYPE} === Field::TABLE)
            {
                $field = $element->{IStructureHasElement::RELATION_ELEMENT};

                if ($element->{IStructureHasElement::TRANSLATABLE})
                {
                    $attributes[$key] = $handle;
                }
                else if ($field->{Field::TYPE} === BuilderField::class)
                {
                    $attributes["$key.*"] = $handle;

                    foreach ($field->{Field::RELATION_BLOCKS} ?? [] as $block)
                    {
                        $this->populateAttributes($attributes, $block->{Block::RELATION_ELEMENTS}, "$key.*.children");
                    }
                }
                else
                {
                    $attributes[$key] = $handle;
                }
            }
            else
            {
                $block = $element->{IStructureHasElement::RELATION_ELEMENT};

                $nextPath = $block->{Block::VIRTUAL} ? $path : $key;

                $this->populateAttributes($attributes, $block->{Block::RELATION_ELEMENTS}, $nextPath);
            }
        }
    }

    /**
     * @param array $rules
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

                $fieldValidationRules =  $field->{Field::RELATION_VALIDATION_RULES}->pluck(ValidationRule::HANDLE)->toArray();

                $fieldRules = [];

                if ($element->{IStructureHasElement::REQUIRED})
                {

                    $fieldRules[] = FormRule::REQUIRED;

                    if (Str::contains($path, 'children'))
                    {
                        $fieldRules[] = FormRule::SOMETIMES;
                    }
                }
                else
                {
                    $fieldRules[] = FormRule::SOMETIMES;
                    $fieldRules[] = FormRule::NULLABLE;
                }

                if ($element->{IStructureHasElement::TRANSLATABLE})
                {
                    $rules[$key] = array_merge([FormRule::ARRAY], $fieldRules);

                    $rules["$key.*"] = $fieldValidationRules;
                }
                else if ($field->{Field::TYPE} === BuilderField::class)
                {
                    $rules["$key.*"] = $fieldRules;

                    foreach ($field->{Field::RELATION_BLOCKS} ?? [] as $block)
                    {
                        $this->populateRules($rules, $block->{Block::RELATION_ELEMENTS}, "$key.*.children");
                    }
                }
                else
                {
                    $rules[$key] = array_merge($fieldRules, $fieldValidationRules);
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
