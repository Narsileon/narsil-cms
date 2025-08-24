<?php

namespace Narsil\Services;

#region USE

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Narsil\Contracts\Fields\CheckboxInput;
use Narsil\Contracts\Fields\DateInput;
use Narsil\Contracts\Fields\RichTextInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Fields\TimeInput;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Entities\Entity;
use Narsil\Services\TemplateService;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
abstract class GraphQLService
{
    #region CONSTANTS

    /**
     * @var array<string,string>
     */
    private const DEFAULT_FIELDS = [
        Entity::UUID => 'String',
        Entity::ID => 'Int',
        Entity::REVISION => 'Int',
        Entity::CREATED_AT => 'DateTime',
        Entity::CREATED_BY => 'Int',
        Entity::UPDATED_AT => 'DateTime',
        Entity::UPDATED_BY => 'Int',
        Entity::DELETED_AT => 'DateTime',
        Entity::DELETED_BY => 'Int',
    ];

    #endregion

    #region PUBLIC METHODS

    /**
     * @return void
     */
    public static function generateTemplatesSchema(): void
    {
        $templates = Template::all();

        $types = static::generateTypes($templates);
        $queries = static::generateQueries($templates);

        file_put_contents(base_path('vendor/narsil/cms/graphql/templates.graphql'), $queries . "\n" . $types);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Collection<Template> $templates
     *
     * @return string
     */
    private static function generateQueries(Collection $templates): string
    {
        $queries = "type Query {\n";

        foreach ($templates as $template)
        {
            $plural = $template->{Template::HANDLE};
            $singular = Str::singular($plural);

            $name = $template->{Template::NAME};

            $model = 'Narsil\\\\Models\\\\Entities\\\\Entity';

            $queries .= "    {$plural}: [$name!]! @table @all(model: \"$model\")\n";
            $queries .= "    {$singular}(uuid: String! @eq): $name @table @find(model: \"$model\")\n";
        }

        $queries .= "}\n";

        return $queries;
    }

    /**
     * @param Collection<Template> $templates
     *
     * @return string
     */
    private static function generateTypes(Collection $templates): string
    {
        $types = "";

        foreach ($templates as $template)
        {
            $name = $template->{Template::NAME};

            $types .= "type $name {\n";

            foreach (static::DEFAULT_FIELDS as $handle => $type)
            {
                $types .= "    $handle: $type\n";
            }

            $fields = TemplateService::getFields($template);

            foreach ($fields as $field)
            {
                $handle = $field->{Field::HANDLE};

                $type = match ($field->{Field::TYPE})
                {
                    CheckboxInput::class => "Boolean",
                    DateInput::class => "Date",
                    RichTextInput::class => "String",
                    TextInput::class => "String",
                    TimeInput::class => "Time",
                    default => "String",
                };

                $types .= "    $handle: $type\n";
            }

            $types .= "}\n";
        }

        return $types;
    }

    #endregion
}
