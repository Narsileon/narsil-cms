<?php

namespace Narsil\Implementations;

#region USE

use Illuminate\Support\Str;
use Narsil\Contracts\Form;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;
use Narsil\Support\LabelsBag;
use ReflectionClass;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractForm implements Form
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        app(LabelsBag::class)
            ->add('narsil-cms::pagination.empty')
            ->add('narsil-cms::placeholders.choose')
            ->add('narsil-cms::ui.back')
            ->add('narsil-cms::ui.create');
    }

    #endregion

    #region PROPERTIES

    /**
     * @var string|null
     */
    public protected(set) ?string $description = null;
    /**
     * @var string|null
     */
    public protected(set) ?string $method = MethodEnum::POST->value;
    /**
     * @var string|null
     */
    public protected(set) ?string $submit = null;
    /**
     * @var string|null
     */
    public protected(set) ?string $title = null;
    /**
     * @var string|null
     */
    public protected(set) ?string $url = null;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): mixed
    {
        return [
            'description' => $this->description,
            'form' => static::form(),
            'id'     => $this->id(),
            'method' => $this->method,
            'submit' => $this->submit,
            'title'  => $this->title,
            'url'    => $this->url,
        ];
    }

    #endregion

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
     * @param ?array $elements
     *
     * @return Block
     */
    protected static function informationBlock(?array $elements = null): Block
    {
        return new Block([
            Block::HANDLE => 'information',
            Block::NAME => trans('narsil-cms::ui.information'),
            Block::RELATION_ELEMENTS => [
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => 'id',
                        Field::NAME => trans('narsil-cms::validation.attributes.id'),
                    ])
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => 'created_at',
                        Field::NAME => trans('narsil-cms::validation.attributes.created_at'),
                    ])
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => 'updated_at',
                        Field::NAME => trans('narsil-cms::validation.attributes.updated_at'),
                    ])
                ]),
            ]
        ]);
    }

    /**
     * @param array $elements
     *
     * @return Block
     */
    protected static function mainBlock(array $elements): Block
    {
        return new Block([
            Block::HANDLE => 'main',
            Block::NAME => trans('narsil-cms::ui.main'),
            Block::RELATION_ELEMENTS => $elements
        ]);
    }

    /**
     * @param array $elements
     *
     * @return Block
     */
    protected static function sidebar(array $elements): Block
    {
        return new Block([
            Block::HANDLE => 'sidebar',
            Block::NAME => trans('narsil-cms::ui.sidebar'),
            Block::RELATION_ELEMENTS => $elements
        ]);
    }

    #endregion

    #region FLUENT METHODS

    /**
     * {@inheritDoc}
     */
    public function description(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function method(MethodEnum $method): static
    {
        $this->method = $method->value;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function submit(string $submit): static
    {
        $this->submit = $submit;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function title(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function url(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    #endregion
}
