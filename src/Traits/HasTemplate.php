<?php

namespace Narsil\Traits;

use Illuminate\Support\Collection;
use Narsil\Contracts\Fields\CheckboxField;
use Narsil\Contracts\Fields\RelationsField;
use Narsil\Contracts\Fields\SwitchField;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Services\TemplateService;

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
trait HasTemplate
{
    #region PROPERTIES

    /**
     * The template associated with the model.
     *
     * @var ?Template
     */
    protected static ?Template $template = null;

    #endregion

    #region PUBLIC METHODS

    /**
     * @return string
     */
    abstract public static function getTableName(): string;

    /**
     * @return Template
     */
    public static function getTemplate(): Template
    {
        return static::$template;
    }

    /**
     * @param Template|string $template
     *
     * @return void
     */
    public static function setTemplate(Template|string $template): void
    {
        if (is_string($template))
        {
            $template = Template::query()
                ->firstWhere([
                    Template::HANDLE,
                    $template
                ]);
        }

        static::$template = $template;
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Collection<Field> $fields
     *
     * @return array<string,string>
     */
    protected function generateCasts(Collection $fields): array
    {
        $casts = [];

        $fields = TemplateService::getTemplateFields(static::$template);

        foreach ($fields as $field)
        {
            switch ($field->{Field::TYPE})
            {
                case CheckboxField::class:
                case SwitchField::class:
                    $casts[$field->{Field::HANDLE}] = 'boolean';
                    break;
                case RelationsField::class:
                    $casts[$field->{Field::HANDLE}] = 'json';
                    break;
                default:
                    break;
            }
        }

        return $casts;
    }

    #endregion
}
