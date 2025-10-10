<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Template;
use Narsil\Models\Elements\TemplateSet;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;

#endregion

return new class extends Migration
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
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
     * {@inheritDoc}
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
                ->morphs(BlockElement::RELATION_ELEMENT);
            $blueprint
                ->string(BlockElement::HANDLE);
            $blueprint
                ->string(BlockElement::NAME);
            $blueprint
                ->integer(BlockElement::POSITION)
                ->nullable();
            $blueprint
                ->smallInteger(BlockElement::WIDTH)
                ->nullable();
        });
    }

    /**
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
                ->string(TemplateSection::NAME);
            $blueprint
                ->integer(TemplateSection::POSITION)
                ->nullable();
            $blueprint
                ->timestamps();
        });
    }

    /**
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
                ->json(Template::NAME);
            $blueprint
                ->timestamps();
        });
    }

    #endregion
};
