<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\BlockElementCondition;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\FieldBlock;
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
        if (!Schema::hasTable(Block::TABLE))
        {
            $this->createBlocksTable();
        }
        if (!Schema::hasTable(BlockElement::TABLE))
        {
            $this->createBlockElementTable();
        }
        if (!Schema::hasTable(BlockElementCondition::TABLE))
        {
            $this->createBlockElementConditionsTable();
        }

        if (!Schema::hasTable(FieldBlock::TABLE))
        {
            $this->createFieldBlockTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(FieldBlock::TABLE);

        Schema::dropIfExists(BlockElementCondition::TABLE);
        Schema::dropIfExists(BlockElement::TABLE);
        Schema::dropIfExists(Block::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the block element conditions table.
     *
     * @return void
     */
    private function createBlockElementConditionsTable(): void
    {
        Schema::create(BlockElementCondition::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(BlockElementCondition::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(BlockElementCondition::BLOCK_ELEMENT_UUID)
                ->constrained(BlockElement::TABLE, BlockElement::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->string(BlockElementCondition::HANDLE);
            $blueprint
                ->string(BlockElementCondition::OPERATOR);
            $blueprint
                ->string(BlockElementCondition::VALUE);
        });
    }

    /**
     * Create the block elements table.
     *
     * @return void
     */
    private function createBlockElementTable(): void
    {
        Schema::create(BlockElement::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(BlockElement::UUID)
                ->primary();
            $blueprint
                ->foreignId(BlockElement::OWNER_ID)
                ->constrained(Block::TABLE, Block::ID)
                ->cascadeOnDelete();
            $blueprint
                ->morphs(BlockElement::RELATION_ELEMENT);
            $blueprint
                ->foreignId(BlockElement::BLOCK_ID)
                ->nullable()
                ->constrained(Block::TABLE, Block::ID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(BlockElement::FIELD_ID)
                ->nullable()
                ->constrained(Field::TABLE, Field::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(BlockElement::HANDLE);
            $blueprint
                ->jsonb(BlockElement::NAME);
            $blueprint
                ->jsonb(BlockElement::DESCRIPTION)
                ->nullable();
            $blueprint
                ->boolean(BlockElement::REQUIRED)
                ->nullable();
            $blueprint
                ->boolean(BlockElement::TRANSLATABLE)
                ->nullable();
            $blueprint
                ->integer(BlockElement::POSITION)
                ->default(0);
            $blueprint
                ->smallInteger(BlockElement::WIDTH)
                ->default(100);
        });
    }

    /**
     * Create the blocks table.
     *
     * @return void
     */
    private function createBlocksTable(): void
    {
        Schema::create(Block::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(Block::ID);
            $blueprint
                ->string(Block::HANDLE)
                ->unique();
            $blueprint
                ->jsonb(Block::NAME);
            $blueprint
                ->boolean(Block::COLLAPSIBLE)
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
     * @return void
     */
    private function createFieldBlockTable(): void
    {
        Schema::create(FieldBlock::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(FieldBlock::UUID)
                ->primary();
            $blueprint
                ->foreignId(FieldBlock::BLOCK_ID)
                ->constrained(Block::TABLE, Block::ID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(FieldBlock::FIELD_ID)
                ->constrained(Field::TABLE, Field::ID)
                ->cascadeOnDelete();
        });
    }

    #endregion
};
