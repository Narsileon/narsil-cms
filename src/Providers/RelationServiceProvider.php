<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Narsil\Models\Collections\Block;
use Narsil\Models\Collections\BlockElement;
use Narsil\Models\Collections\Field;
use Narsil\Models\Collections\Template;
use Narsil\Models\Collections\TemplateTab;
use Narsil\Models\Collections\TemplateTabElement;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Forms\Fieldset;
use Narsil\Models\Forms\FieldsetElement;
use Narsil\Models\Forms\Form;
use Narsil\Models\Forms\FormTab;
use Narsil\Models\Forms\FormTabElement;
use Narsil\Models\Forms\Input;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\Header;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Models\Hosts\HostLocaleLanguage;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\User;

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
        $this->bootMorphMap();
        $this->bootTemplateMorphMap();
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
            FormTab::TABLE => FormTab::class,
            FormTabElement::TABLE => FormTabElement::class,
            Header::TABLE => Header::class,
            Host::TABLE => Host::class,
            HostLocale::TABLE => HostLocale::class,
            HostLocaleLanguage::TABLE => HostLocaleLanguage::class,
            Input::TABLE => Input::class,
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
        Cache::tags([Template::TABLE])->rememberForever('morph_map', function ()
        {
            $templates = Template::all();

            foreach ($templates as $template)
            {
                Relation::enforceMorphMap([
                    $template->entityTable() => $template->entityClass(),
                ]);
            }
        });
    }

    #endregion
}
