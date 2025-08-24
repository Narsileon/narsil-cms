<?php

namespace Narsil\Enums\Forms;

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
enum MethodEnum: string
{
    case GET   = 'get';
    case PATCH = 'patch';
    case POST  = 'post';
    case PUT   = 'put';
}
