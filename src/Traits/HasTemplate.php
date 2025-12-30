<?php

namespace Narsil\Traits;

#region USE

use Illuminate\Support\Collection;
use Narsil\Casts\JsonCast;
use Narsil\Contracts\Fields\CheckboxField;
use Narsil\Contracts\Fields\RelationsField;
use Narsil\Contracts\Fields\SwitchField;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\Template;
use Narsil\Services\CollectionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
trait HasTemplate
{
    use HasTranslations;

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
     * @return ?Template
     */
    public static function getTemplate(): ?Template
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

        $fields = CollectionService::getTemplateFields(static::$template);

        foreach ($fields as $field)
        {
            if ($field->{Field::TRANSLATABLE})
            {
                $casts[$field->{Field::HANDLE}] = JsonCast::class;
            }
            else
            {
                switch ($field->{Field::TYPE})
                {
                    case CheckboxField::class:
                    case SwitchField::class:
                        $casts[$field->{Field::HANDLE}] = 'boolean';
                        break;
                    case RelationsField::class:
                        $casts[$field->{Field::HANDLE}] = 'array';
                        break;
                    default:
                        break;
                }
            }

            if ($field->{Field::TRANSLATABLE})
            {
                $this->translatable[] = $field->{Field::HANDLE};
            }
        }

        return $casts;
    }

    #endregion
}
