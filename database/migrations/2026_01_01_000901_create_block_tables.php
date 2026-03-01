<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Base\Enums\OperatorEnum;
use Narsil\Base\Models\User;
use Narsil\Base\Traits\HasSchemas;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\BlockElementCondition;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\FieldBlock;

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
            if (!Schema::hasTable("$schema." . Block::TABLE))
            {
                $this->createBlocksTable($schema);
            }
            if (!Schema::hasTable("$schema." . BlockElement::TABLE))
            {
                $this->createBlockElementTable($schema);
            }
            if (!Schema::hasTable("$schema." . BlockElementCondition::TABLE))
            {
                $this->createBlockElementConditionsTable($schema);
            }

            if (!Schema::hasTable("$schema." . FieldBlock::TABLE))
            {
                $this->createFieldBlockTable($schema);
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
            Schema::dropIfExists("$schema." . FieldBlock::TABLE);

            Schema::dropIfExists("$schema." . BlockElementCondition::TABLE);
            Schema::dropIfExists("$schema." . BlockElement::TABLE);
            Schema::dropIfExists("$schema." . Block::TABLE);
        };
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the block element conditions table.
     *
     * @param string $schema
     *
     * @return void
     */
    private function createBlockElementConditionsTable(string $schema): void
    {
        Schema::create("$schema." . BlockElementCondition::TABLE, function (Blueprint $blueprint) use ($schema)
        {
            $blueprint
                ->uuid(BlockElementCondition::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(BlockElementCondition::BLOCK_ELEMENT_UUID)
                ->constrained("$schema." . BlockElement::TABLE, BlockElement::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->integer(BlockElementCondition::POSITION)
                ->default(0)
                ->index();
            $blueprint
                ->string(BlockElementCondition::HANDLE);
            $blueprint
                ->enum(BlockElementCondition::OPERATOR, OperatorEnum::values())
                ->default(OperatorEnum::EQUALS);
            $blueprint
                ->string(BlockElementCondition::VALUE);
        });
    }

    /**
     * Create the block elements table.
     *
     * @param string $schema
     *
     * @return void
     */
    private function createBlockElementTable(string $schema): void
    {
        Schema::create("$schema." . BlockElement::TABLE, function (Blueprint $blueprint) use ($schema)
        {
            $blueprint
                ->uuid(BlockElement::UUID)
                ->primary();
            $blueprint
                ->foreignId(BlockElement::OWNER_ID)
                ->constrained("$schema." . Block::TABLE, Block::ID)
                ->cascadeOnDelete();
            $blueprint
                ->morphs(BlockElement::RELATION_BASE);
            $blueprint
                ->foreignId(BlockElement::BLOCK_ID)
                ->nullable()
                ->constrained("$schema." . Block::TABLE, Block::ID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(BlockElement::FIELD_ID)
                ->nullable()
                ->constrained("$schema." . Field::TABLE, Field::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(BlockElement::HANDLE);
            $blueprint
                ->jsonb(BlockElement::LABEL);
            $blueprint
                ->jsonb(BlockElement::DESCRIPTION)
                ->nullable();
            $blueprint
                ->boolean(BlockElement::REQUIRED)
                ->default(false);
            $blueprint
                ->boolean(BlockElement::TRANSLATABLE)
                ->default(false);
            $blueprint
                ->integer(BlockElement::POSITION)
                ->default(0)
                ->index();
            $blueprint
                ->smallInteger(BlockElement::WIDTH)
                ->default(100);
        });
    }

    /**
     * Create the blocks table.
     *
     * @param string $schema
     *
     * @return void
     */
    private function createBlocksTable(string $schema): void
    {
        Schema::create("$schema." . Block::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(Block::ID);
            $blueprint
                ->string(Block::HANDLE)
                ->unique();
            $blueprint
                ->jsonb(Block::LABEL);
            $blueprint
                ->boolean(Block::COLLAPSIBLE)
                ->default(false);
            $blueprint
                ->boolean(Block::VIRTUAL)
                ->default(false);
            $blueprint
                ->timestamp(Block::CREATED_AT);
            $blueprint
                ->foreignId(Block::CREATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
            $blueprint
                ->timestamp(Block::UPDATED_AT);
            $blueprint
                ->foreignId(Block::UPDATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
        });
    }

    /**
     * Create the block set table.
     *
     * @param string $schema
     *
     * @return void
     */
    private function createFieldBlockTable(string $schema): void
    {
        Schema::create("$schema." . FieldBlock::TABLE, function (Blueprint $blueprint) use ($schema)
        {
            $blueprint
                ->uuid(FieldBlock::UUID)
                ->primary();
            $blueprint
                ->foreignId(FieldBlock::BLOCK_ID)
                ->constrained("$schema." . Block::TABLE, Block::ID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(FieldBlock::FIELD_ID)
                ->constrained("$schema." . Field::TABLE, Field::ID)
                ->cascadeOnDelete();
        });
    }

    #endregion
};
