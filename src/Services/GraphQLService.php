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
use Narsil\Services\TemplateService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class GraphQLService
{
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

            $fields = TemplateService::getFields($template);

            $types .= "type $name {\n";

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
