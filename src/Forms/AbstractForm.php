<?php

namespace Narsil\Forms;

#region USE

use Illuminate\Support\Str;
use Narsil\Contracts\Forms\Form;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Models\Fields\Field;
use Narsil\Support\LabelsBag;
use ReflectionClass;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractForm implements Form
{
    #region CONSTANTS

    /**
     * @var string
     */
    final protected const DATA = 'data';
    /**
     * @var string
     */
    final protected const MAIN = 'main';
    /**
     * @var string
     */
    final protected const SIDEBAR = 'sidebar';

    #endregion

    #region PROPERTIES

    /**
     * @var string
     */
    public readonly string $method;
    /**
     * @var string
     */
    public readonly string $submit;
    /**
     * @var string
     */
    public readonly string $url;

    #endregion

    #region PUBLIC METHODS

    /**
     * @return array<Field>
     */
    abstract public function fields(): array;

    /**
     * {@inheritDoc}
     */
    public function get(
        string $url,
        MethodEnum $method,
        string $submit,
    ): array
    {
        $this->method = $method->value;
        $this->submit = $submit;
        $this->url = $url;

        $this->registerLabels();

        return [
            'fields' => $this->fields(),
            'id'     => $this->id(),
            'method' => $this->method,
            'submit' => $this->submit,
            'url'    => $this->url,
        ];
    }


    #region PROTECTED METHODS

    /**
     * @return string
     */
    protected function id(): string
    {
        $name = (new ReflectionClass(static::class))->getShortName();

        return Str::slug(Str::snake($name));
    }

    /**
     * @return void
     */
    protected function registerLabels(): void
    {
        app(LabelsBag::class)
            ->add('narsil-cms::accessibility.align_center')
            ->add('narsil-cms::accessibility.align_justify')
            ->add('narsil-cms::accessibility.align_left')
            ->add('narsil-cms::accessibility.align_right')
            ->add('narsil-cms::accessibility.redo')
            ->add('narsil-cms::accessibility.required')
            ->add('narsil-cms::accessibility.toggle_bold')
            ->add('narsil-cms::accessibility.toggle_bullet_list')
            ->add('narsil-cms::accessibility.toggle_heading_1')
            ->add('narsil-cms::accessibility.toggle_heading_2')
            ->add('narsil-cms::accessibility.toggle_heading_3')
            ->add('narsil-cms::accessibility.toggle_heading_4')
            ->add('narsil-cms::accessibility.toggle_heading_5')
            ->add('narsil-cms::accessibility.toggle_heading_6')
            ->add('narsil-cms::accessibility.toggle_heading_menu')
            ->add('narsil-cms::accessibility.toggle_italic')
            ->add('narsil-cms::accessibility.toggle_ordered_list')
            ->add('narsil-cms::accessibility.toggle_strike')
            ->add('narsil-cms::accessibility.toggle_subscript')
            ->add('narsil-cms::accessibility.toggle_superscript')
            ->add('narsil-cms::accessibility.toggle_underline')
            ->add('narsil-cms::accessibility.undo')
            ->add('narsil-cms::pagination.empty')
            ->add('narsil-cms::ui.back');
    }

    #endregion
}
