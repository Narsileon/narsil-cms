<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Enums\Database\OperatorEnum;
use Narsil\Models\Collections\Block;
use Narsil\Models\Collections\Field;
use Narsil\Models\Collections\Template;
use Narsil\Models\Collections\TemplateTab;
use Narsil\Models\Collections\TemplateTabElement;
use Narsil\Models\Collections\TemplateTabElementCondition;
use Narsil\Models\User;

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
        if (!Schema::hasTable(TemplateTab::TABLE))
        {
            $this->createTemplateTabsTable();
        }
        if (!Schema::hasTable(TemplateTabElement::TABLE))
        {
            $this->createTemplateTabElementTable();
        }
        if (!Schema::hasTable(TemplateTabElementCondition::TABLE))
        {
            $this->createTemplateTabElementConditionsTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(TemplateTabElementCondition::TABLE);
        Schema::dropIfExists(TemplateTabElement::TABLE);
        Schema::dropIfExists(TemplateTab::TABLE);
        Schema::dropIfExists(Template::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the template tab element conditions table.
     *
     * @return void
     */
    private function createTemplateTabElementConditionsTable(): void
    {
        Schema::create(TemplateTabElementCondition::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(TemplateTabElementCondition::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(TemplateTabElementCondition::TEMPLATE_TAB_ELEMENT_UUID)
                ->constrained(TemplateTabElement::TABLE, TemplateTabElement::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->integer(TemplateTabElementCondition::POSITION)
                ->default(0);
            $blueprint
                ->string(TemplateTabElementCondition::HANDLE);
            $blueprint
                ->enum(TemplateTabElementCondition::OPERATOR, OperatorEnum::values())
                ->default(OperatorEnum::EQUALS);
            $blueprint
                ->string(TemplateTabElementCondition::VALUE);
        });
    }

    /**
     * Create the template tab elements table.
     *
     * @return void
     */
    private function createTemplateTabElementTable(): void
    {
        Schema::create(TemplateTabElement::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(TemplateTabElement::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(TemplateTabElement::OWNER_UUID)
                ->constrained(TemplateTab::TABLE, TemplateTab::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->morphs(TemplateTabElement::RELATION_BASE);
            $blueprint
                ->foreignId(TemplateTabElement::BLOCK_ID)
                ->nullable()
                ->constrained(Block::TABLE, Block::ID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(TemplateTabElement::FIELD_ID)
                ->nullable()
                ->constrained(Field::TABLE, Field::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(TemplateTabElement::HANDLE);
            $blueprint
                ->jsonb(TemplateTabElement::LABEL);
            $blueprint
                ->jsonb(TemplateTabElement::DESCRIPTION)
                ->nullable();
            $blueprint
                ->boolean(TemplateTabElement::REQUIRED)
                ->default(false);
            $blueprint
                ->boolean(TemplateTabElement::TRANSLATABLE)
                ->default(false);
            $blueprint
                ->integer(TemplateTabElement::POSITION)
                ->default(0);
            $blueprint
                ->smallInteger(TemplateTabElement::WIDTH)
                ->default(100);
        });
    }

    /**
     * Create the template tabs table.
     *
     * @return void
     */
    private function createTemplateTabsTable(): void
    {
        Schema::create(TemplateTab::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(TemplateTab::UUID)
                ->primary();
            $blueprint
                ->foreignId(TemplateTab::TEMPLATE_ID)
                ->constrained(Template::TABLE, Template::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(TemplateTab::HANDLE);
            $blueprint
                ->jsonb(TemplateTab::LABEL);
            $blueprint
                ->integer(TemplateTab::POSITION)
                ->default(0);
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
                ->string(Template::TABLE_NAME)
                ->unique();
            $blueprint
                ->jsonb(Template::SINGULAR);
            $blueprint
                ->jsonb(Template::PLURAL);
            $blueprint
                ->timestamp(Template::CREATED_AT);
            $blueprint
                ->foreignId(Template::CREATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
            $blueprint
                ->timestamp(Template::UPDATED_AT);
            $blueprint
                ->foreignId(Template::UPDATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
        });
    }

    #endregion
};
