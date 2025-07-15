<?php

namespace App\Enums\Forms;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum MethodEnum: string
{
    case GET   = 'get';
    case PATCH = 'patch';
    case POST  = 'post';
    case PUT   = 'put';
}
