<?php

declare(strict_types=1);

namespace Narsil\Cms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Narsil\Base\Contracts\Menus\AuthMenu;
use Narsil\Base\Contracts\Menus\GuestMenu;
use Narsil\Base\Contracts\Menus\Home;
use Narsil\Base\Http\Data\Forms\Inputs\AssetInputData;
use Narsil\Base\Http\Data\Forms\Inputs\CheckboxInputData;
use Narsil\Base\Http\Data\Forms\Inputs\DateInputData;
use Narsil\Base\Http\Data\Forms\Inputs\DatetimeInputData;
use Narsil\Base\Http\Data\Forms\Inputs\EmailInputData;
use Narsil\Base\Http\Data\Forms\Inputs\FileInputData;
use Narsil\Base\Http\Data\Forms\Inputs\IconInputData;
use Narsil\Base\Http\Data\Forms\Inputs\NumberInputData;
use Narsil\Base\Http\Data\Forms\Inputs\PasswordInputData;
use Narsil\Base\Http\Data\Forms\Inputs\RangeInputData;
use Narsil\Base\Http\Data\Forms\Inputs\RichTextInputData;
use Narsil\Base\Http\Data\Forms\Inputs\SelectInputData;
use Narsil\Base\Http\Data\Forms\Inputs\SwitchInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TableInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TextareaInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TimeInputData;
use Narsil\Base\Narsil;
use Narsil\Base\Providers\ActionServiceProvider;
use Narsil\Base\Providers\FormRequestServiceProvider;
use Narsil\Base\Providers\FormServiceProvider;
use Narsil\Base\Providers\FortifyServiceProvider;
use Narsil\Base\Providers\HorizonServiceProvider;
use Narsil\Base\Providers\ResourceServiceProvider;
use Narsil\Cms\Contracts\Actions\Blocks\ReplicateBlock;
use Narsil\Cms\Contracts\Actions\Blocks\SyncBlockElements;
use Narsil\Cms\Contracts\Actions\Elements\SyncElementConditions;
use Narsil\Cms\Contracts\Actions\Entities\ReplicateEntity;
use Narsil\Cms\Contracts\Actions\Entities\SyncEntityNodes;
use Narsil\Cms\Contracts\Actions\Fields\ReplicateField;
use Narsil\Cms\Contracts\Actions\Fields\SyncFieldBlocks;
use Narsil\Cms\Contracts\Actions\Fields\SyncFieldOptions;
use Narsil\Cms\Contracts\Actions\Fields\SyncFieldValidationRules;
use Narsil\Cms\Contracts\Actions\Footers\ReplicateFooter;
use Narsil\Cms\Contracts\Actions\Footers\SyncFooterLinks;
use Narsil\Cms\Contracts\Actions\Footers\SyncFooterSocialMedia;
use Narsil\Cms\Contracts\Actions\Headers\ReplicateHeader;
use Narsil\Cms\Contracts\Actions\Hosts\ReplicateHost;
use Narsil\Cms\Contracts\Actions\Hosts\SyncHostLocaleLanguages;
use Narsil\Cms\Contracts\Actions\Hosts\SyncHostLocales;
use Narsil\Cms\Contracts\Actions\LiveEditor\CreateEntityBlockNode;
use Narsil\Cms\Contracts\Actions\LiveEditor\DeleteEntityNode;
use Narsil\Cms\Contracts\Actions\LiveEditor\ReorderEntityNodes;
use Narsil\Cms\Contracts\Actions\LiveEditor\UpdateEntityNode;
use Narsil\Cms\Contracts\Actions\Sites\SyncSitePageEntities;
use Narsil\Cms\Contracts\Actions\Templates\ReplicateTemplate;
use Narsil\Cms\Contracts\Actions\Templates\SyncTemplateTabElements;
use Narsil\Cms\Contracts\Actions\Templates\SyncTemplateTabs;
use Narsil\Cms\Contracts\Forms\BlockElementForm;
use Narsil\Cms\Contracts\Forms\BlockForm;
use Narsil\Cms\Contracts\Forms\ConditionForm;
use Narsil\Cms\Contracts\Forms\EntityForm;
use Narsil\Cms\Contracts\Forms\FieldForm;
use Narsil\Cms\Contracts\Forms\FooterForm;
use Narsil\Cms\Contracts\Forms\HeaderForm;
use Narsil\Cms\Contracts\Forms\HostForm;
use Narsil\Cms\Contracts\Forms\LiveEditor\EntityNodeInspectorForm;
use Narsil\Cms\Contracts\Forms\PublishForm;
use Narsil\Cms\Contracts\Forms\RedirectForm;
use Narsil\Cms\Contracts\Forms\SiteForm;
use Narsil\Cms\Contracts\Forms\SitePageForm;
use Narsil\Cms\Contracts\Forms\TemplateForm;
use Narsil\Cms\Contracts\Forms\TemplateTabElementForm;
use Narsil\Cms\Contracts\Forms\TemplateTabForm;
use Narsil\Cms\Contracts\Menus\CmsSidebar;
use Narsil\Cms\Contracts\Requests\BlockFormRequest;
use Narsil\Cms\Contracts\Requests\EntityFormRequest;
use Narsil\Cms\Contracts\Requests\FieldFormRequest;
use Narsil\Cms\Contracts\Requests\FooterFormRequest;
use Narsil\Cms\Contracts\Requests\HeaderFormRequest;
use Narsil\Cms\Contracts\Requests\HostFormRequest;
use Narsil\Cms\Contracts\Requests\RedirectFormRequest;
use Narsil\Cms\Contracts\Requests\SitePageFormRequest;
use Narsil\Cms\Contracts\Requests\TemplateFormRequest;
use Narsil\Cms\Contracts\Resources\EntityResource;
use Narsil\Cms\Definitions\BlockDefinition;
use Narsil\Cms\Definitions\FieldDefinition;
use Narsil\Cms\Definitions\FooterDefinition;
use Narsil\Cms\Definitions\HeaderDefinition;
use Narsil\Cms\Definitions\HostDefinition;
use Narsil\Cms\Definitions\RedirectDefinition;
use Narsil\Cms\Definitions\TemplateDefinition;
use Narsil\Cms\Http\Data\Forms\Inputs\BuilderInputData;
use Narsil\Cms\Http\Data\Forms\Inputs\EntityInputData;
use Narsil\Cms\Http\Data\Forms\Inputs\LinkInputData;
use Narsil\Cms\Implementations\Tables\EntityTable;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Collections\TemplateTabElement;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\Header;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Hosts\HostLocale;
use Narsil\Cms\Models\Hosts\HostLocaleLanguage;
use Narsil\Cms\Models\Redirect;
use Narsil\Cms\Models\Sites\SitePage;
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
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'narsil-cms');

        $this->bootNarsilRoutes(base_path('/vendor/narsil/base/routes/users.php'));

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

    /**
     * Register the package defaults.
     *
     * @return void
     */
    protected function registerDefaults(): void
    {
        $narsil = $this->app->make(Narsil::class);

        $narsil
            ->action(ReplicateBlock::class, Implementations\Actions\Blocks\ReplicateBlock::class)
            ->action(SyncBlockElements::class, Implementations\Actions\Blocks\SyncBlockElements::class)
            ->action(SyncElementConditions::class, Implementations\Actions\Elements\SyncElementConditions::class)
            ->action(ReplicateEntity::class, Implementations\Actions\Entities\ReplicateEntity::class)
            ->action(SyncEntityNodes::class, Implementations\Actions\Entities\SyncEntityNodes::class)
            ->modelDefinition(Header::class, HeaderDefinition::class)
            ->modelDefinition(Block::class, BlockDefinition::class)
            ->modelDefinition(Field::class, FieldDefinition::class)
            ->modelDefinition(Footer::class, FooterDefinition::class)
            ->modelDefinition(Host::class, HostDefinition::class)
            ->modelDefinition(Template::class, TemplateDefinition::class)
            ->action(ReplicateField::class, Implementations\Actions\Fields\ReplicateField::class)
            ->action(SyncFieldBlocks::class, Implementations\Actions\Fields\SyncFieldBlocks::class)
            ->action(SyncFieldOptions::class, Implementations\Actions\Fields\SyncFieldOptions::class)
            ->action(SyncFieldValidationRules::class, Implementations\Actions\Fields\SyncFieldValidationRules::class)
            ->action(ReplicateFooter::class, Implementations\Actions\Footers\ReplicateFooter::class)
            ->action(SyncFooterLinks::class, Implementations\Actions\Footers\SyncFooterLinks::class)
            ->action(SyncFooterSocialMedia::class, Implementations\Actions\Footers\SyncFooterSocialMedia::class)
            ->action(ReplicateHeader::class, Implementations\Actions\Headers\ReplicateHeader::class)
            ->action(ReplicateHost::class, Implementations\Actions\Hosts\ReplicateHost::class)
            ->action(SyncHostLocaleLanguages::class, Implementations\Actions\Hosts\SyncHostLocaleLanguages::class)
            ->action(SyncHostLocales::class, Implementations\Actions\Hosts\SyncHostLocales::class)
            ->action(CreateEntityBlockNode::class, Implementations\Actions\LiveEditor\CreateEntityBlockNode::class)
            ->action(DeleteEntityNode::class, Implementations\Actions\LiveEditor\DeleteEntityNode::class)
            ->action(ReorderEntityNodes::class, Implementations\Actions\LiveEditor\ReorderEntityNodes::class)
            ->action(UpdateEntityNode::class, Implementations\Actions\LiveEditor\UpdateEntityNode::class)
            ->action(SyncSitePageEntities::class, Implementations\Actions\Sites\SyncSitePageEntities::class)
            ->action(ReplicateTemplate::class, Implementations\Actions\Templates\ReplicateTemplate::class)
            ->action(SyncTemplateTabElements::class, Implementations\Actions\Templates\SyncTemplateTabElements::class)
            ->action(SyncTemplateTabs::class, Implementations\Actions\Templates\SyncTemplateTabs::class)
            ->form(BlockElementForm::class, Implementations\Forms\BlockElementForm::class)
            ->form(BlockForm::class, Implementations\Forms\BlockForm::class)
            ->form(ConditionForm::class, Implementations\Forms\ConditionForm::class)
            ->form(EntityForm::class, Implementations\Forms\EntityForm::class)
            ->form(FieldForm::class, Implementations\Forms\FieldForm::class)
            ->form(FooterForm::class, Implementations\Forms\FooterForm::class)
            ->form(HeaderForm::class, Implementations\Forms\HeaderForm::class)
            ->form(HostForm::class, Implementations\Forms\HostForm::class)
            ->form(EntityNodeInspectorForm::class, Implementations\Forms\LiveEditor\EntityNodeInspectorForm::class)
            ->form(PublishForm::class, Implementations\Forms\PublishForm::class)
            ->form(RedirectForm::class, Implementations\Forms\RedirectForm::class)
            ->form(SiteForm::class, Implementations\Forms\SiteForm::class)
            ->form(SitePageForm::class, Implementations\Forms\SitePageForm::class)
            ->form(TemplateForm::class, Implementations\Forms\TemplateForm::class)
            ->form(TemplateTabElementForm::class, Implementations\Forms\TemplateTabElementForm::class)
            ->form(TemplateTabForm::class, Implementations\Forms\TemplateTabForm::class)
            ->menu(AuthMenu::class, Implementations\Menus\AuthMenu::class)
            ->menu(GuestMenu::class, Implementations\Menus\GuestMenu::class)
            ->menu(Home::class, Implementations\Menus\Home::class)
            ->menu(CmsSidebar::class, Implementations\Menus\CmsSidebar::class)
            ->request(BlockFormRequest::class, Implementations\Requests\BlockFormRequest::class)
            ->request(EntityFormRequest::class, Implementations\Requests\EntityFormRequest::class)
            ->request(FieldFormRequest::class, Implementations\Requests\FieldFormRequest::class)
            ->request(FooterFormRequest::class, Implementations\Requests\FooterFormRequest::class)
            ->request(HeaderFormRequest::class, Implementations\Requests\HeaderFormRequest::class)
            ->request(HostFormRequest::class, Implementations\Requests\HostFormRequest::class)
            ->request(RedirectFormRequest::class, Implementations\Requests\RedirectFormRequest::class)
            ->request(SitePageFormRequest::class, Implementations\Requests\SitePageFormRequest::class)
            ->request(TemplateFormRequest::class, Implementations\Requests\TemplateFormRequest::class)
            ->resource(EntityResource::class, Implementations\Resources\EntityResource::class)
            ->modelDefinition(Redirect::class, RedirectDefinition::class)
            ->field(AssetInputData::TYPE, AssetInputData::class)
            ->field(CheckboxInputData::TYPE, CheckboxInputData::class)
            ->field(DateInputData::TYPE, DateInputData::class)
            ->field(DatetimeInputData::TYPE, DatetimeInputData::class)
            ->field(EmailInputData::TYPE, EmailInputData::class)
            ->field(FileInputData::TYPE, FileInputData::class)
            ->field(IconInputData::TYPE, IconInputData::class)
            ->field(NumberInputData::TYPE, NumberInputData::class)
            ->field(PasswordInputData::TYPE, PasswordInputData::class)
            ->field(RangeInputData::TYPE, RangeInputData::class)
            ->field(RichTextInputData::TYPE, RichTextInputData::class)
            ->field(SelectInputData::TYPE, SelectInputData::class)
            ->field(SwitchInputData::TYPE, SwitchInputData::class)
            ->field(TableInputData::TYPE, TableInputData::class)
            ->field(TextareaInputData::TYPE, TextareaInputData::class)
            ->field(TextInputData::TYPE, TextInputData::class)
            ->field(TimeInputData::TYPE, TimeInputData::class)
            ->field(BuilderInputData::TYPE, BuilderInputData::class)
            ->field(EntityInputData::TYPE, EntityInputData::class)
            ->field(LinkInputData::TYPE, LinkInputData::class)
            ->morph(BlockElement::class, BlockElement::TABLE)
            ->morph(TemplateTab::class, TemplateTab::TABLE)
            ->morph(TemplateTabElement::class, TemplateTabElement::TABLE)
            ->morph(Entity::class, Entity::TABLE)
            ->morph(HostLocale::class, HostLocale::TABLE)
            ->morph(HostLocaleLanguage::class, HostLocaleLanguage::TABLE)
            ->morph(SitePage::class, SitePage::TABLE)
            ->table(Entity::TABLE, EntityTable::class)
            ->relation(LinkInputData::TYPE);
    }

    /**
     * Register the package service providers.
     *
     * @return void
     */
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
