<?php

namespace Narsil\GraphQL\Scalars;

#region USE

use GraphQL\Error\Error;
use GraphQL\Language\Printer;
use GraphQL\Type\Definition\ScalarType;
use JsonException;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class JSON extends ScalarType
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function parseLiteral($valueNode, ?array $variables = null)
    {
        if (!property_exists($valueNode, 'value'))
        {
            $withoutValue = Printer::doPrint($valueNode);

            throw new Error("Can not parse literals without a value: {$withoutValue}.");
        }

        return $this->decodeJSON($valueNode->value);
    }

    /**
     * {@inheritDoc}
     */
    public function parseValue(mixed $value): mixed
    {
        return $this->decodeJSON($value);
    }

    /**
     * {@inheritDoc}
     */
    public function serialize(mixed $value): string
    {
        return json_encode($value);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Try to decode a JSON value.
     *
     * @param mixed $value
     *
     * @throws Error
     *
     * @return mixed
     */
    protected function decodeJSON(mixed $value): mixed
    {
        try
        {
            $decoded = json_decode($value);
        }
        catch (JsonException $jsonException)
        {
            throw new Error($jsonException->getMessage());
        }

        return $decoded;
    }

    #endregion
}
