<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Fields\Field;
use Narsil\Models\Fields\FieldCondition;
use Narsil\Models\Fields\FieldSet;
use Narsil\Models\Fields\FieldSetElement;
use Narsil\Models\Fields\TemplateSectionElement;
use Narsil\Models\Templates\Template;
use Narsil\Models\Templates\TemplateSection;

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
        Schema::dropIfExists(FieldSetElement::TABLE);
        Schema::dropIfExists(FieldSet::TABLE);
        Schema::dropIfExists(FieldCondition::TABLE);
        Schema::dropIfExists(Field::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

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
                ->morphs(FieldSetElement::RELATION_ELEMENT);
            $table
                ->integer(FieldSetElement::POSITION)
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
