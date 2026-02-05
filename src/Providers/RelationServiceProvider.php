<?php

namespace Narsil\Cms\Providers;

#region USE

use Exception;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Collections\TemplateTabElement;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Models\Forms\Fieldset;
use Narsil\Cms\Models\Forms\FieldsetElement;
use Narsil\Cms\Models\Forms\Form;
use Narsil\Cms\Models\Forms\FormStep;
use Narsil\Cms\Models\Forms\FormStepElement;
use Narsil\Cms\Models\Forms\Input;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\Header;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Hosts\HostLocale;
use Narsil\Cms\Models\Hosts\HostLocaleLanguage;
use Narsil\Cms\Models\Policies\Permission;
use Narsil\Cms\Models\Policies\Role;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Models\Storages\Media;
use Narsil\Cms\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RelationServiceProvider extends ServiceProvider
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
        Relation::enforceMorphMap([
            Block::TABLE => Block::class,
            BlockElement::TABLE => BlockElement::class,
            Entity::TABLE => Entity::class,
            Field::TABLE => Field::class,
            Fieldset::TABLE => Fieldset::class,
            FieldsetElement::TABLE => FieldsetElement::class,
            Footer::TABLE => Footer::class,
            Form::TABLE => Form::class,
            FormStep::TABLE => FormStep::class,
            FormStepElement::TABLE => FormStepElement::class,
            Header::TABLE => Header::class,
            Host::TABLE => Host::class,
            HostLocale::TABLE => HostLocale::class,
            HostLocaleLanguage::TABLE => HostLocaleLanguage::class,
            Input::TABLE => Input::class,
            Media::TABLE => Media::class,
            Permission::TABLE => Permission::class,
            Role::TABLE => Role::class,
            SitePage::TABLE => SitePage::class,
            TemplateTab::TABLE => TemplateTab::class,
            TemplateTabElement::TABLE => TemplateTabElement::class,
            User::TABLE => User::class,
        ]);
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
