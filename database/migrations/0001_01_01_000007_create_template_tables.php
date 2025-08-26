<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Template;
use Narsil\Models\Elements\TemplateBlock;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;

#endregion

return new class extends Migration
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    public function up(): void
    {
        if (!Schema::hasTable(Template::TABLE))
        {
            $this->createTemplatesTable();
        }
        if (!Schema::hasTable(TemplateBlock::TABLE))
        {
            $this->createTemplateBlocksTable();
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
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(TemplateSectionElement::TABLE);
        Schema::dropIfExists(TemplateSection::TABLE);
        Schema::dropIfExists(TemplateBlock::TABLE);
        Schema::dropIfExists(Template::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return void
     */
    private function createTemplateBlocksTable(): void
    {
        Schema::create(TemplateBlock::TABLE, function (Blueprint $table)
        {
            $table
                ->id(TemplateBlock::ID);
            $table
                ->foreignId(TemplateBlock::TEMPLATE_ID)
                ->constrained(Template::TABLE, Template::ID)
                ->cascadeOnDelete();
            $table
                ->foreignId(TemplateBlock::BLOCK_ID)
                ->constrained(Block::TABLE, Block::ID)
                ->cascadeOnDelete();
        });
    }


    /**
     * @return void
     */
    private function createTemplateSectionElementTable(): void
    {
        Schema::create(TemplateSectionElement::TABLE, function (Blueprint $table)
        {
            $table
                ->id(TemplateSectionElement::ID);
            $table
                ->foreignId(TemplateSectionElement::TEMPLATE_SECTION_ID)
                ->constrained(TemplateSection::TABLE, TemplateSection::ID)
                ->cascadeOnDelete();
            $table
                ->morphs(BlockElement::RELATION_ELEMENT);
            $table
                ->string(BlockElement::HANDLE);
            $table
                ->string(BlockElement::NAME);
            $table
                ->integer(BlockElement::POSITION)
                ->nullable();
            $table
                ->smallInteger(BlockElement::WIDTH)
                ->nullable();
        });
    }

    /**
     * @return void
     */
    private function createTemplateSectionsTable(): void
    {
        Schema::create(TemplateSection::TABLE, function (Blueprint $table)
        {
            $table
                ->id(TemplateSection::ID);
            $table
                ->foreignId(TemplateSection::TEMPLATE_ID)
                ->constrained(Template::TABLE, Template::ID)
                ->cascadeOnDelete();
            $table
                ->string(TemplateSection::HANDLE);
            $table
                ->string(TemplateSection::NAME);
            $table
                ->integer(TemplateSection::POSITION)
                ->nullable();
            $table
                ->timestamps();
        });
    }

    /**
     * @return void
     */
    private function createTemplatesTable(): void
    {
        Schema::create(Template::TABLE, function (Blueprint $table)
        {
            $table
                ->id(Template::ID);
            $table
                ->string(Template::HANDLE);
            $table
                ->string(Template::NAME);
            $table
                ->timestamps();
        });
    }

    #endregion
};
