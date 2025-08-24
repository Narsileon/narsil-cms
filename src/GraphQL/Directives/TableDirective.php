<?php

namespace Narsil\GraphQL\Directives;

#region USE

use Illuminate\Support\Str;
use Narsil\Models\Entities\Entity;
use Nuwave\Lighthouse\Execution\ResolveInfo;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Support\Contracts\FieldMiddleware;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class TableDirective extends BaseDirective implements FieldMiddleware
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function definition(): string
    {
        return
            /** @lang GraphQL */
            <<<'GRAPHQL'
directive @table on FIELD_DEFINITION
GRAPHQL;
    }

    /**
     * {@inheritDoc}
     */
    public function handleField(FieldValue $fieldValue): void
    {
        $fieldValue->wrapResolver(function (callable $resolver)
        {
            return function ($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) use ($resolver)
            {
                $fieldName = $resolveInfo->fieldName;

                Entity::setTableName(Str::plural($fieldName));

                $result = $resolver($root, $args, $context, $resolveInfo);

                return $result;
            };
        });
    }

    #endregion
}
