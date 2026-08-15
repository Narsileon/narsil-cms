<?php

declare(strict_types=1);

namespace Narsil\Cms\Contracts\Actions\Templates;

#region USE

use Narsil\Base\Contracts\Action;
use Narsil\Cms\Models\Collections\Template;

#endregion

interface ReplicateTemplate extends Action
{
    #region PUBLIC METHODS

    /**
     * @param Template $template
     *
     * @return Template
     */
    public function run(Template $template): Template;

    #endregion
}
