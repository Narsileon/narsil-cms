<?php

namespace Narsil\Cms\Providers;

#region USE

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Narsil\Base\Models\Users\UserConfiguration;
use Narsil\Base\Providers\MorphServiceProvider as BaseMorphServiceProvider;
use Narsil\Base\Traits\HasSchemas;
use Narsil\Cms\Models\Collections\Template;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
final class MorphServiceProvider extends BaseMorphServiceProvider
{
    use HasSchemas;

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function bootMorphMap(): void
    {
        parent::bootMorphMap();

        $schema = Session::get(UserConfiguration::SCHEMA, 'cms');

        $this->setSearchPath($schema);

        $map = Cache::tags([Template::TABLE, $schema])->rememberForever('morph_map', function ()
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
