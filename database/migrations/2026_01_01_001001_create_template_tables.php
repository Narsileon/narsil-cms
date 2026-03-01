<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Base\Enums\OperatorEnum;
use Narsil\Base\Models\User;
use Narsil\Base\Traits\HasSchemas;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Collections\TemplateTabElement;
use Narsil\Cms\Models\Collections\TemplateTabElementCondition;

#endregion

return new class extends Migration
{
    use HasSchemas;

    #region PUBLIC METHODS

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        foreach ($this->getSchemas() as $schema)
        {
            if (!Schema::hasTable("$schema." . Template::TABLE))
            {
                $this->createTemplatesTable($schema);
            }
            if (!Schema::hasTable("$schema." . TemplateTab::TABLE))
            {
                $this->createTemplateTabsTable($schema);
            }
            if (!Schema::hasTable("$schema." . TemplateTabElement::TABLE))
            {
                $this->createTemplateTabElementTable($schema);
            }
            if (!Schema::hasTable("$schema." . TemplateTabElementCondition::TABLE))
            {
                $this->createTemplateTabElementConditionsTable($schema);
            }
        };
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        foreach ($this->getSchemas() as $schema)
        {
            Schema::dropIfExists("$schema." . TemplateTabElementCondition::TABLE);
            Schema::dropIfExists("$schema." . TemplateTabElement::TABLE);
            Schema::dropIfExists("$schema." . TemplateTab::TABLE);
            Schema::dropIfExists("$schema." . Template::TABLE);
        };
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the template tab element conditions table.
     *
     * @param string $schema
     *
     * @return void
     */
    private function createTemplateTabElementConditionsTable(string $schema): void
    {
        Schema::create("$schema." . TemplateTabElementCondition::TABLE, function (Blueprint $blueprint) use ($schema)
        {
            $blueprint
                ->uuid(TemplateTabElementCondition::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(TemplateTabElementCondition::TEMPLATE_TAB_ELEMENT_UUID)
                ->constrained("$schema." . TemplateTabElement::TABLE, TemplateTabElement::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->integer(TemplateTabElementCondition::POSITION)
                ->default(0)
                ->index();
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
     * @param string $schema
     *
     * @return void
     */
    private function createTemplateTabElementTable(string $schema): void
    {
        Schema::create("$schema." . TemplateTabElement::TABLE, function (Blueprint $blueprint) use ($schema)
        {
            $blueprint
                ->uuid(TemplateTabElement::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(TemplateTabElement::OWNER_UUID)
                ->constrained("$schema." . TemplateTab::TABLE, TemplateTab::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->morphs(TemplateTabElement::RELATION_BASE);
            $blueprint
                ->foreignId(TemplateTabElement::BLOCK_ID)
                ->nullable()
                ->constrained("$schema." . Block::TABLE, Block::ID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(TemplateTabElement::FIELD_ID)
                ->nullable()
                ->constrained("$schema." . Field::TABLE, Field::ID)
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
                ->default(0)
                ->index();
            $blueprint
                ->smallInteger(TemplateTabElement::WIDTH)
                ->default(100);
        });
    }

    /**
     * Create the template tabs table.
     *
     * @param string $schema
     *
     * @return void
     */
    private function createTemplateTabsTable(string $schema): void
    {
        Schema::create("$schema." . TemplateTab::TABLE, function (Blueprint $blueprint) use ($schema)
        {
            $blueprint
                ->uuid(TemplateTab::UUID)
                ->primary();
            $blueprint
                ->foreignId(TemplateTab::TEMPLATE_ID)
                ->constrained("$schema." . Template::TABLE, Template::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(TemplateTab::HANDLE);
            $blueprint
                ->jsonb(TemplateTab::LABEL);
            $blueprint
                ->integer(TemplateTab::POSITION)
                ->default(0)
                ->index();
            $blueprint
                ->timestamps();
        });
    }

    /**
     * Create the templates table.
     *
     * @param string $schema
     *
     * @return void
     */
    private function createTemplatesTable(string $schema): void
    {
        Schema::create("$schema." . Template::TABLE, function (Blueprint $blueprint)
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
