<?php

namespace Narsil\Services;

#region USE

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Narsil\Contracts\Fields\CheckboxField;
use Narsil\Contracts\Fields\DateField;
use Narsil\Contracts\Fields\RichTextField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Fields\TimeField;
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
    protected const DEFAULT_FIELDS = [
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
    protected static function generateQueries(Collection $templates): string
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
    protected static function generateTypes(Collection $templates): string
    {
        $types = "";

        foreach ($templates as $template)
        {
            $types .= static::getCollectionType($template);
            $types .= static::getCollectionBlockType($template);
        }

        return $types;
    }

    /**
     * @param Template $template
     *
     * @return string
     */
    protected static function getCollectionType(Template $template): string
    {
        $collectionName = $template->{Template::NAME};
        $collectionBlockName = static::getCollectionBlockName($template);

        $definition = "";

        $definition .= "type $collectionName {\n";

        foreach (static::DEFAULT_FIELDS as $handle => $type)
        {
            $definition .= "\t$handle: $type\n";
        }

        $fields = TemplateService::getTemplateFields($template);

        foreach ($fields as $field)
        {
            $handle = $field->{Field::HANDLE};

            $type = match ($field->{Field::TYPE})
            {
                CheckboxField::class => "Boolean",
                DateField::class => "Date",
                RichTextField::class => "String",
                TextField::class => "String",
                TimeField::class => "Time",
                default => "String",
            };

            $definition .= "\t$handle: $type\n";
        }

        $definition .= "\tblocks: [$collectionBlockName] @hasMany\n";
        $definition .= "}\n\n";

        return $definition;
    }

    /**
     * @param Template $template
     *
     * @return string
     */
    protected static function getCollectionBlockName(Template $template): string
    {
        return Str::singular($template->{Template::NAME}) . "Block";;
    }

    /**
     * @param Template $template
     *
     * @return string
     */
    protected static function getCollectionBlockType(Template $template): string
    {
        $collectionBlockName = static::getCollectionBlockName($template);

        $definition = "";

        $definition .= "type $collectionBlockName {\n";
        $definition .= "\tid: ID!\n";
        $definition .= "\tentity_uuid: String\n";
        $definition .= "\tparent_id: ID!\n";
        $definition .= "\tblock_id: ID!\n";
        $definition .= "\tposition: Int!\n";
        $definition .= "\tvalues: JSON\n";
        $definition .= "\tblock: Block!\n";
        $definition .= "\tchildren: [$collectionBlockName]\n";
        $definition .= "}\n\n";

        return $definition;
    }

    #endregion
}
