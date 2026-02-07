<?php

namespace Narsil\Cms\Providers;

#region USE

use Exception;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Narsil\Cms\Models\Collections\Template;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
final class MorphServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * Boot any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        try
        {
            $this->bootMorphMap();
            $this->bootTemplateMorphMap();
        }
        catch (Exception $exception)
        {
            Log::error($exception);
        }
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Boot the morph map.
     *
     * @return void
     */
    protected function bootMorphMap(): void
    {

        $config = Config::get('narsil.models.morphs', []);

        $map = [];

        foreach ($config as $class => $table)
        {
            $map[$table] = $class;
        }

        Relation::enforceMorphMap($map);
    }

    /**
     * Boot the template morph map.
     *
     * @return void
     */
    protected function bootTemplateMorphMap(): void
    {
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
