<?php

namespace Narsil\Cms\Providers;

#region USE

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Cache;
use Narsil\Base\Providers\MorphServiceProvider as BaseMorphServiceProvider;
use Narsil\Cms\Models\Collections\Template;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
final class MorphServiceProvider extends BaseMorphServiceProvider
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function bootMorphMap(): void
    {
        parent::bootMorphMap();

        $map = Cache::tags([Template::TABLE])->rememberForever('morph_map', function ()
        {
            $templates = Template::query()
                ->without([Template::RELATION_TABS])
                ->get();

            $map = [];

            foreach ($templates as $template)
            {
                $map[$template->entityTable()] = $template->entityClass();
            }

            return $map;
        });

        Relation::enforceMorphMap($map);
    }

    #endregion
}
