<?php

namespace Narsil\Cms\Http\Collections;

#region USE

use Narsil\Base\Http\Collections\DataTableCollection as BaseDataTableCollection;
use Narsil\Base\Support\TranslationsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class DataTableCollection extends BaseDataTableCollection
{
    #region PUBLIC METHODS

    #region • FLUENT

    /**
     * @param boolean $revisionable
     *
     * @return static
     */
    public function setRevisionable(bool $revisionable): static
    {
        $this->options['revisionable'] = $revisionable;

        if ($revisionable)
        {
            app(TranslationsBag::class)
                ->add('narsil-cms::revisions.draft')
                ->add('narsil-cms::revisions.published')
                ->add('narsil-cms::revisions.saved');
        }

        return $this;
    }

    #endregion

    #endregion
}
