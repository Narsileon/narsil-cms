<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\BlockElementCondition;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\FieldBlock;

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
                ->id(BlockElementCondition::ID);
            $blueprint
                ->foreignId(BlockElementCondition::OWNER_ID)
                ->constrained(BlockElement::TABLE, BlockElement::ID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(BlockElementCondition::TARGET_ID)
                ->constrained(BlockElement::TABLE, BlockElement::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(BlockElementCondition::OPERATOR);
            $blueprint
                ->string(BlockElementCondition::VALUE);
            $blueprint
                ->timestamps();
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
                ->id(BlockElement::ID);
            $blueprint
                ->foreignId(BlockElement::BLOCK_ID)
                ->constrained(Block::TABLE, Block::ID)
                ->cascadeOnDelete();
            $blueprint
                ->morphs(BlockElement::RELATION_ELEMENT);
            $blueprint
                ->string(BlockElement::HANDLE);
            $blueprint
                ->jsonb(BlockElement::NAME);
            $blueprint
                ->jsonb(BlockElement::DESCRIPTION)
                ->default(new Expression('(JSON_OBJECT())'));
            $blueprint
                ->integer(BlockElement::POSITION)
                ->nullable();
            $blueprint
                ->smallInteger(BlockElement::WIDTH)
                ->nullable();
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
                ->timestamps();
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
                ->id(FieldBlock::ID);
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
