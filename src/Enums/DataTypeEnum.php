<?php

namespace Narsil\Cms\Enums;

#region USE

use Narsil\Cms\Traits\Enumerable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum DataTypeEnum: string
{
    use Enumerable;

    case BIGINT = 'bigint';
    case BINARY = 'binary';
    case BOOLEAN = 'boolean';
    case DATE = 'date';
    case DATETIME = 'datetime';
    case DECIMAL = 'decimal';
    case DOUBLE = 'double';
    case ENUM = 'enum';
    case FLOAT = 'float';
    case FLOAT4 = 'float4';
    case FLOAT8 = 'float8';
    case INT2 = 'int2';
    case INT4 = 'int4';
    case INT8 = 'int8';
    case INTEGER = 'integer';
    case JSON = 'json';
    case JSONB = 'jsonb';
    case LONGTEXT = 'longtext';
    case NUMERIC = 'numeric';
    case SET = 'set';
    case SMALLINT = 'smallint';
    case STRING = 'string';
    case TEXT = 'text';
    case TIME = 'time';
    case TIMESTAMP = 'timestamp';
    case UUID = 'uuid';
    case VARCHAR = 'varchar';
}
