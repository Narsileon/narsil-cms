<?php

namespace Narsil\Enums\Revisions;

#region USE

use Narsil\Traits\Enumerable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum RevisionStatusEnum: string
{
    use Enumerable;

    case ARCHIVED = 'archived';
    case DRAFT = 'draft';
    case PUBLISHED = 'live';
    case SAVED = 'saved';
}
