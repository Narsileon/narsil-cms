<?php

namespace Narsil\Enums\Database;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum TypeNameEnum: string
{
    case BIGINT      = 'bigint';
    case BINARY      = 'binary';
    case BOOLEAN     = 'boolean';
    case DATE        = 'date';
    case DATETIME    = 'datetime';
    case DECIMAL     = 'decimal';
    case DOUBLE      = 'double';
    case ENUM        = 'enum';
    case FLOAT       = 'float';
    case INTEGER     = 'integer';
    case JSON        = 'json';
    case SET         = 'set';
    case SMALLINT    = 'smallint';
    case STRING      = 'string';
    case TEXT        = 'text';
    case TIME        = 'time';
    case TIMESTAMP   = 'timestamp';
    case UUID        = 'uuid';
    case VARCHAR     = 'varchar';
}
