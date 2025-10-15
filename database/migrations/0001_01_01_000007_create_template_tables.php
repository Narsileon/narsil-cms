<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Template;
use Narsil\Models\Elements\TemplateSet;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;

#endregion

return new class extends Migration
{
    #region PUBLIC METHODS

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        if (!Schema::hasTable(Template::TABLE))
        {
            $this->createTemplatesTable();
        }
        if (!Schema::hasTable(TemplateSet::TABLE))
        {
            $this->createTemplateSetsTable();
        }
        if (!Schema::hasTable(TemplateSection::TABLE))
        {
            $this->createTemplateSectionsTable();
        }
        if (!Schema::hasTable(TemplateSectionElement::TABLE))
        {
            $this->createTemplateSectionElementTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(TemplateSectionElement::TABLE);
        Schema::dropIfExists(TemplateSection::TABLE);
        Schema::dropIfExists(TemplateSet::TABLE);
        Schema::dropIfExists(Template::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the template sets table.
     *
     * @return void
     */
    private function createTemplateSetsTable(): void
    {
        Schema::create(TemplateSet::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(TemplateSet::ID);
            $blueprint
                ->foreignId(TemplateSet::TEMPLATE_ID)
                ->constrained(Template::TABLE, Template::ID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(TemplateSet::SET_ID)
                ->constrained(Block::TABLE, Block::ID)
                ->cascadeOnDelete();
        });
    }

    /**
     * Create the template section elements table.
     *
     * @return void
     */
    private function createTemplateSectionElementTable(): void
    {
        Schema::create(TemplateSectionElement::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(TemplateSectionElement::ID);
            $blueprint
                ->foreignId(TemplateSectionElement::TEMPLATE_SECTION_ID)
                ->constrained(TemplateSection::TABLE, TemplateSection::ID)
                ->cascadeOnDelete();
            $blueprint
                ->morphs(TemplateSectionElement::RELATION_ELEMENT);
            $blueprint
                ->string(TemplateSectionElement::HANDLE);
            $blueprint
                ->jsonb(TemplateSectionElement::NAME);
            $blueprint
                ->jsonb(TemplateSectionElement::DESCRIPTION)
                ->default(new Expression('(JSON_OBJECT())'));
            $blueprint
                ->integer(TemplateSectionElement::POSITION)
                ->nullable();
            $blueprint
                ->smallInteger(TemplateSectionElement::WIDTH)
                ->nullable();
        });
    }

    /**
     * Create the template sections table.
     *
     * @return void
     */
    private function createTemplateSectionsTable(): void
    {
        Schema::create(TemplateSection::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(TemplateSection::ID);
            $blueprint
                ->foreignId(TemplateSection::TEMPLATE_ID)
                ->constrained(Template::TABLE, Template::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(TemplateSection::HANDLE);
            $blueprint
                ->jsonb(TemplateSection::NAME);
            $blueprint
                ->integer(TemplateSection::POSITION)
                ->nullable();
            $blueprint
                ->timestamps();
        });
    }

    /**
     * Create the templates table.
     *
     * @return void
     */
    private function createTemplatesTable(): void
    {
        Schema::create(Template::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(Template::ID);
            $blueprint
                ->string(Template::HANDLE);
            $blueprint
                ->jsonb(Template::NAME);
            $blueprint
                ->timestamps();
        });
    }

    #endregion
};
