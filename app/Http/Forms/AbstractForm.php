<?php

namespace App\Http\Forms;

#region USE

use App\Enums\Forms\MethodEnum;
use App\Contracts\Forms\Form;
use App\Support\Forms\Input;
use App\Support\LabelsBag;
use Illuminate\Support\Str;
use ReflectionClass;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractForm implements Form
{
    #region PUBLIC METHODS

    /**
     * {@inheritdoc}
     */
    public function get(
        string $action,
        MethodEnum $method,
        string $submit,
    ): array
    {
        $this->action = $action;
        $this->method = $method->value;
        $this->submit = $submit;

        $this->registerLabels();

        return [
            'action'  => $this->action,
            'content' => $this->getContent(),
            'id'      => $this->getId(),
            'method'  => $this->method,
            'options' => $this->getOptions(),
            'submit'  => $this->submit,
        ];
    }

    #endregion

    #region PROPERTIES

    /**
     * @var string
     */
    public readonly string $action;
    /**
     * @var string
     */
    public readonly string $method;
    /**
     * @var string
     */
    public readonly string $submit;

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<Input>
     */
    abstract protected function getContent(): array;

    /**
     * @return string
     */
    protected function getId(): string
    {
        $name = (new ReflectionClass(static::class))->getShortName();

        return Str::slug(Str::snake($name));
    }

    /**
     * @return array
     */
    protected function getOptions(): array
    {
        return [];
    }

    /**
     * @return void
     */
    protected function registerLabels(): void
    {
        app(LabelsBag::class)
            ->add('accessibility.align_center')
            ->add('accessibility.align_justify')
            ->add('accessibility.align_left')
            ->add('accessibility.align_right')
            ->add('accessibility.redo')
            ->add('accessibility.required')
            ->add('accessibility.toggle_bold')
            ->add('accessibility.toggle_bullet_list')
            ->add('accessibility.toggle_heading_1')
            ->add('accessibility.toggle_heading_2')
            ->add('accessibility.toggle_heading_3')
            ->add('accessibility.toggle_heading_4')
            ->add('accessibility.toggle_heading_5')
            ->add('accessibility.toggle_heading_6')
            ->add('accessibility.toggle_heading_menu')
            ->add('accessibility.toggle_italic')
            ->add('accessibility.toggle_ordered_list')
            ->add('accessibility.toggle_strike')
            ->add('accessibility.toggle_subscript')
            ->add('accessibility.toggle_superscript')
            ->add('accessibility.toggle_underline')
            ->add('accessibility.undo')
            ->add('pagination.empty')
            ->add('ui.back');
    }

    #endregion
}
