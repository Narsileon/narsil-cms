<?php

declare(strict_types=1);

namespace Narsil\Cms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Narsil\Base\Narsil;
use Narsil\Base\Providers\ActionServiceProvider;
use Narsil\Base\Providers\FormRequestServiceProvider;
use Narsil\Base\Providers\FormServiceProvider;
use Narsil\Base\Providers\FortifyServiceProvider;
use Narsil\Base\Providers\HorizonServiceProvider;
use Narsil\Base\Providers\ResourceServiceProvider;
use Narsil\Cms\Providers\CommandServiceProvider;
use Narsil\Cms\Providers\MenuServiceProvider;
use Narsil\Cms\Providers\MiddlewareServiceProvider;
use Narsil\Cms\Providers\MigrationServiceProvider;
use Narsil\Cms\Providers\MorphServiceProvider;
use Narsil\Cms\Providers\NarsilServiceProvider;
use Narsil\Cms\Providers\TranslationServiceProvider;

#endregion

class ServiceProvider extends NarsilServiceProvider
{
    #region PUBLIC METHODS

    /**
     * Boot any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'narsil-cms');

        $this->bootNarsilRoutes(base_path('/vendor/narsil/base/routes/users.php'));

        Route::middleware([
            'web',
            'narsil',
        ])
            ->prefix('narsil')
            ->group(function ()
            {
                Route::redirect('/', '/narsil/cms');
            });

        $this->bootApiRoutes(__DIR__ . '/../routes/api.php');
        $this->bootCmsRoutes(__DIR__ . '/../routes/cms.php');
        $this->bootWebRoutes(__DIR__ . '/../routes/web.php');

        $this->bootPublishes();

        Model::preventLazyLoading(!App::isProduction());
    }

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->registerDefaults();

        $this->app->booting(function ()
        {
            $this->registerProviders();
        });
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Register the package defaults.
     *
     * @return void
     */
    protected function registerDefaults(): void
    {
        $narsil = $this->app->make(Narsil::class);

        $narsil
            ->action(\Narsil\Cms\Contracts\Actions\Blocks\ReplicateBlock::class, \Narsil\Cms\Implementations\Actions\Blocks\ReplicateBlock::class)
            ->action(\Narsil\Cms\Contracts\Actions\Blocks\SyncBlockElements::class, \Narsil\Cms\Implementations\Actions\Blocks\SyncBlockElements::class)
            ->action(\Narsil\Cms\Contracts\Actions\Elements\SyncElementConditions::class, \Narsil\Cms\Implementations\Actions\Elements\SyncElementConditions::class)
            ->action(\Narsil\Cms\Contracts\Actions\Entities\ReplicateEntity::class, \Narsil\Cms\Implementations\Actions\Entities\ReplicateEntity::class)
            ->action(\Narsil\Cms\Contracts\Actions\Entities\SyncEntityNodes::class, \Narsil\Cms\Implementations\Actions\Entities\SyncEntityNodes::class)
            ->modelDefinition(\Narsil\Cms\Models\Globals\Header::class, \Narsil\Cms\Implementations\Definitions\HeaderDefinition::class)
            ->modelDefinition(\Narsil\Cms\Models\Collections\Block::class, \Narsil\Cms\Implementations\Definitions\BlockDefinition::class)
            ->modelDefinition(\Narsil\Cms\Models\Collections\Field::class, \Narsil\Cms\Implementations\Definitions\FieldDefinition::class)
            ->modelDefinition(\Narsil\Cms\Models\Globals\Footer::class, \Narsil\Cms\Implementations\Definitions\FooterDefinition::class)
            ->modelDefinition(\Narsil\Cms\Models\Hosts\Host::class, \Narsil\Cms\Implementations\Definitions\HostDefinition::class)
            ->modelDefinition(\Narsil\Cms\Models\Collections\Template::class, \Narsil\Cms\Implementations\Definitions\TemplateDefinition::class)
            ->action(\Narsil\Cms\Contracts\Actions\Fields\ReplicateField::class, \Narsil\Cms\Implementations\Actions\Fields\ReplicateField::class)
            ->action(\Narsil\Cms\Contracts\Actions\Fields\SyncFieldBlocks::class, \Narsil\Cms\Implementations\Actions\Fields\SyncFieldBlocks::class)
            ->action(\Narsil\Cms\Contracts\Actions\Fields\SyncFieldOptions::class, \Narsil\Cms\Implementations\Actions\Fields\SyncFieldOptions::class)
            ->action(\Narsil\Cms\Contracts\Actions\Fields\SyncFieldValidationRules::class, \Narsil\Cms\Implementations\Actions\Fields\SyncFieldValidationRules::class)
            ->action(\Narsil\Cms\Contracts\Actions\Footers\ReplicateFooter::class, \Narsil\Cms\Implementations\Actions\Footers\ReplicateFooter::class)
            ->action(\Narsil\Cms\Contracts\Actions\Footers\SyncFooterLinks::class, \Narsil\Cms\Implementations\Actions\Footers\SyncFooterLinks::class)
            ->action(\Narsil\Cms\Contracts\Actions\Footers\SyncFooterSocialMedia::class, \Narsil\Cms\Implementations\Actions\Footers\SyncFooterSocialMedia::class)
            ->action(\Narsil\Cms\Contracts\Actions\Headers\ReplicateHeader::class, \Narsil\Cms\Implementations\Actions\Headers\ReplicateHeader::class)
            ->action(\Narsil\Cms\Contracts\Actions\Hosts\ReplicateHost::class, \Narsil\Cms\Implementations\Actions\Hosts\ReplicateHost::class)
            ->action(\Narsil\Cms\Contracts\Actions\Hosts\SyncHostLocaleLanguages::class, \Narsil\Cms\Implementations\Actions\Hosts\SyncHostLocaleLanguages::class)
            ->action(\Narsil\Cms\Contracts\Actions\Hosts\SyncHostLocales::class, \Narsil\Cms\Implementations\Actions\Hosts\SyncHostLocales::class)
            ->action(\Narsil\Cms\Contracts\Actions\LiveEditor\CreateEntityBlockNode::class, \Narsil\Cms\Implementations\Actions\LiveEditor\CreateEntityBlockNode::class)
            ->action(\Narsil\Cms\Contracts\Actions\LiveEditor\DeleteEntityNode::class, \Narsil\Cms\Implementations\Actions\LiveEditor\DeleteEntityNode::class)
            ->action(\Narsil\Cms\Contracts\Actions\LiveEditor\ReorderEntityNodes::class, \Narsil\Cms\Implementations\Actions\LiveEditor\ReorderEntityNodes::class)
            ->action(\Narsil\Cms\Contracts\Actions\LiveEditor\UpdateEntityNode::class, \Narsil\Cms\Implementations\Actions\LiveEditor\UpdateEntityNode::class)
            ->action(\Narsil\Cms\Contracts\Actions\Sites\SyncSitePageEntities::class, \Narsil\Cms\Implementations\Actions\Sites\SyncSitePageEntities::class)
            ->action(\Narsil\Cms\Contracts\Actions\Templates\ReplicateTemplate::class, \Narsil\Cms\Implementations\Actions\Templates\ReplicateTemplate::class)
            ->action(\Narsil\Cms\Contracts\Actions\Templates\SyncTemplateTabElements::class, \Narsil\Cms\Implementations\Actions\Templates\SyncTemplateTabElements::class)
            ->action(\Narsil\Cms\Contracts\Actions\Templates\SyncTemplateTabs::class, \Narsil\Cms\Implementations\Actions\Templates\SyncTemplateTabs::class)
            ->form(\Narsil\Cms\Contracts\Forms\BlockElementForm::class, \Narsil\Cms\Implementations\Forms\BlockElementForm::class)
            ->form(\Narsil\Cms\Contracts\Forms\BlockForm::class, \Narsil\Cms\Implementations\Forms\BlockForm::class)
            ->form(\Narsil\Cms\Contracts\Forms\ConditionForm::class, \Narsil\Cms\Implementations\Forms\ConditionForm::class)
            ->form(\Narsil\Cms\Contracts\Forms\ConfigurationForm::class, \Narsil\Cms\Implementations\Forms\ConfigurationForm::class)
            ->form(\Narsil\Cms\Contracts\Forms\EntityForm::class, \Narsil\Cms\Implementations\Forms\EntityForm::class)
            ->form(\Narsil\Cms\Contracts\Forms\FieldForm::class, \Narsil\Cms\Implementations\Forms\FieldForm::class)
            ->form(\Narsil\Cms\Contracts\Forms\FooterForm::class, \Narsil\Cms\Implementations\Forms\FooterForm::class)
            ->form(\Narsil\Cms\Contracts\Forms\HeaderForm::class, \Narsil\Cms\Implementations\Forms\HeaderForm::class)
            ->form(\Narsil\Cms\Contracts\Forms\HostForm::class, \Narsil\Cms\Implementations\Forms\HostForm::class)
            ->form(\Narsil\Cms\Contracts\Forms\LiveEditor\EntityNodeInspectorForm::class, \Narsil\Cms\Implementations\Forms\LiveEditor\EntityNodeInspectorForm::class)
            ->form(\Narsil\Cms\Contracts\Forms\PublishForm::class, \Narsil\Cms\Implementations\Forms\PublishForm::class)
            ->form(\Narsil\Cms\Contracts\Forms\SiteForm::class, \Narsil\Cms\Implementations\Forms\SiteForm::class)
            ->form(\Narsil\Cms\Contracts\Forms\SitePageForm::class, \Narsil\Cms\Implementations\Forms\SitePageForm::class)
            ->form(\Narsil\Cms\Contracts\Forms\TemplateForm::class, \Narsil\Cms\Implementations\Forms\TemplateForm::class)
            ->form(\Narsil\Cms\Contracts\Forms\TemplateTabElementForm::class, \Narsil\Cms\Implementations\Forms\TemplateTabElementForm::class)
            ->form(\Narsil\Cms\Contracts\Forms\TemplateTabForm::class, \Narsil\Cms\Implementations\Forms\TemplateTabForm::class)
            ->menu(\Narsil\Cms\Contracts\Menus\AuthMenu::class, \Narsil\Cms\Implementations\Menus\AuthMenu::class)
            ->menu(\Narsil\Cms\Contracts\Menus\GuestMenu::class, \Narsil\Cms\Implementations\Menus\GuestMenu::class)
            ->menu(\Narsil\Cms\Contracts\Menus\Sidebar::class, \Narsil\Cms\Implementations\Menus\Sidebar::class)
            ->request(\Narsil\Cms\Contracts\Requests\BlockFormRequest::class, \Narsil\Cms\Implementations\Requests\BlockFormRequest::class)
            ->request(\Narsil\Cms\Contracts\Requests\ConfigurationFormRequest::class, \Narsil\Cms\Implementations\Requests\ConfigurationFormRequest::class)
            ->request(\Narsil\Cms\Contracts\Requests\EntityFormRequest::class, \Narsil\Cms\Implementations\Requests\EntityFormRequest::class)
            ->request(\Narsil\Cms\Contracts\Requests\FieldFormRequest::class, \Narsil\Cms\Implementations\Requests\FieldFormRequest::class)
            ->request(\Narsil\Cms\Contracts\Requests\FooterFormRequest::class, \Narsil\Cms\Implementations\Requests\FooterFormRequest::class)
            ->request(\Narsil\Cms\Contracts\Requests\HeaderFormRequest::class, \Narsil\Cms\Implementations\Requests\HeaderFormRequest::class)
            ->request(\Narsil\Cms\Contracts\Requests\HostFormRequest::class, \Narsil\Cms\Implementations\Requests\HostFormRequest::class)
            ->request(\Narsil\Cms\Contracts\Requests\SitePageFormRequest::class, \Narsil\Cms\Implementations\Requests\SitePageFormRequest::class)
            ->request(\Narsil\Cms\Contracts\Requests\TemplateFormRequest::class, \Narsil\Cms\Implementations\Requests\TemplateFormRequest::class)
            ->resource(\Narsil\Cms\Contracts\Resources\EntityResource::class, \Narsil\Cms\Implementations\Resources\EntityResource::class)
            ->field(\Narsil\Base\Http\Data\Forms\Inputs\AssetInputData::TYPE, \Narsil\Base\Http\Data\Forms\Inputs\AssetInputData::class)
            ->field(\Narsil\Base\Http\Data\Forms\Inputs\CheckboxInputData::TYPE, \Narsil\Base\Http\Data\Forms\Inputs\CheckboxInputData::class)
            ->field(\Narsil\Base\Http\Data\Forms\Inputs\DateInputData::TYPE, \Narsil\Base\Http\Data\Forms\Inputs\DateInputData::class)
            ->field(\Narsil\Base\Http\Data\Forms\Inputs\DatetimeInputData::TYPE, \Narsil\Base\Http\Data\Forms\Inputs\DatetimeInputData::class)
            ->field(\Narsil\Base\Http\Data\Forms\Inputs\EmailInputData::TYPE, \Narsil\Base\Http\Data\Forms\Inputs\EmailInputData::class)
            ->field(\Narsil\Base\Http\Data\Forms\Inputs\FileInputData::TYPE, \Narsil\Base\Http\Data\Forms\Inputs\FileInputData::class)
            ->field(\Narsil\Base\Http\Data\Forms\Inputs\IconInputData::TYPE, \Narsil\Base\Http\Data\Forms\Inputs\IconInputData::class)
            ->field(\Narsil\Base\Http\Data\Forms\Inputs\NumberInputData::TYPE, \Narsil\Base\Http\Data\Forms\Inputs\NumberInputData::class)
            ->field(\Narsil\Base\Http\Data\Forms\Inputs\PasswordInputData::TYPE, \Narsil\Base\Http\Data\Forms\Inputs\PasswordInputData::class)
            ->field(\Narsil\Base\Http\Data\Forms\Inputs\RangeInputData::TYPE, \Narsil\Base\Http\Data\Forms\Inputs\RangeInputData::class)
            ->field(\Narsil\Base\Http\Data\Forms\Inputs\RichTextInputData::TYPE, \Narsil\Base\Http\Data\Forms\Inputs\RichTextInputData::class)
            ->field(\Narsil\Base\Http\Data\Forms\Inputs\SelectInputData::TYPE, \Narsil\Base\Http\Data\Forms\Inputs\SelectInputData::class)
            ->field(\Narsil\Base\Http\Data\Forms\Inputs\SwitchInputData::TYPE, \Narsil\Base\Http\Data\Forms\Inputs\SwitchInputData::class)
            ->field(\Narsil\Base\Http\Data\Forms\Inputs\TableInputData::TYPE, \Narsil\Base\Http\Data\Forms\Inputs\TableInputData::class)
            ->field(\Narsil\Base\Http\Data\Forms\Inputs\TextareaInputData::TYPE, \Narsil\Base\Http\Data\Forms\Inputs\TextareaInputData::class)
            ->field(\Narsil\Base\Http\Data\Forms\Inputs\TextInputData::TYPE, \Narsil\Base\Http\Data\Forms\Inputs\TextInputData::class)
            ->field(\Narsil\Base\Http\Data\Forms\Inputs\TimeInputData::TYPE, \Narsil\Base\Http\Data\Forms\Inputs\TimeInputData::class)
            ->field(\Narsil\Cms\Http\Data\Forms\Inputs\BuilderInputData::TYPE, \Narsil\Cms\Http\Data\Forms\Inputs\BuilderInputData::class)
            ->field(\Narsil\Cms\Http\Data\Forms\Inputs\EntityInputData::TYPE, \Narsil\Cms\Http\Data\Forms\Inputs\EntityInputData::class)
            ->field(\Narsil\Cms\Http\Data\Forms\Inputs\LinkInputData::TYPE, \Narsil\Cms\Http\Data\Forms\Inputs\LinkInputData::class)
            ->morph(\Narsil\Cms\Models\Collections\BlockElement::class, \Narsil\Cms\Models\Collections\BlockElement::TABLE)
            ->morph(\Narsil\Cms\Models\Collections\TemplateTab::class, \Narsil\Cms\Models\Collections\TemplateTab::TABLE)
            ->morph(\Narsil\Cms\Models\Collections\TemplateTabElement::class, \Narsil\Cms\Models\Collections\TemplateTabElement::TABLE)
            ->morph(\Narsil\Cms\Models\Entities\Entity::class, \Narsil\Cms\Models\Entities\Entity::TABLE)
            ->morph(\Narsil\Cms\Models\Hosts\HostLocale::class, \Narsil\Cms\Models\Hosts\HostLocale::TABLE)
            ->morph(\Narsil\Cms\Models\Hosts\HostLocaleLanguage::class, \Narsil\Cms\Models\Hosts\HostLocaleLanguage::TABLE)
            ->morph(\Narsil\Cms\Models\Sites\SitePage::class, \Narsil\Cms\Models\Sites\SitePage::TABLE)
            ->table(\Narsil\Cms\Models\Entities\Entity::TABLE, \Narsil\Cms\Implementations\Tables\EntityTable::class)
            ->relation(\Narsil\Cms\Http\Data\Forms\Inputs\LinkInputData::TYPE);
    }


    /**
     * Boot the publishes.
     *
     * @return void
     */
    protected function bootPublishes(): void
    {
        $this->publishes([
            __DIR__ . '/../lang' => lang_path('vendor/narsil-cms'),
        ], 'narsil-cms-lang');
    }

    protected function registerProviders(): void
    {
        $this->app->register(ActionServiceProvider::class);
        $this->app->register(CommandServiceProvider::class);
        $this->app->register(FormRequestServiceProvider::class);
        $this->app->register(FormServiceProvider::class);
        $this->app->register(FortifyServiceProvider::class);
        $this->app->register(HorizonServiceProvider::class);
        $this->app->register(MenuServiceProvider::class);
        $this->app->register(MiddlewareServiceProvider::class);
        $this->app->register(MigrationServiceProvider::class);
        $this->app->register(MorphServiceProvider::class);
        $this->app->register(ResourceServiceProvider::class);
        $this->app->register(TranslationServiceProvider::class);
    }

    #endregion
}
