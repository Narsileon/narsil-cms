<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\BlockElementCondition;
use Narsil\Models\Elements\BlockSet;

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
        if (!Schema::hasTable(BlockSet::TABLE))
        {
            $this->createBlockSetTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(BlockSet::TABLE);
        Schema::dropIfExists(BlockElementCondition::TABLE);
        Schema::dropIfExists(BlockElement::TABLE);
        Schema::dropIfExists(Block::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
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
                ->json(BlockElement::NAME);
            $blueprint
                ->json(BlockElement::DESCRIPTION)
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
     * @return void
     */
    private function createBlocksTable(): void
    {
        Schema::create(Block::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(Block::ID);
            $blueprint
                ->string(Block::HANDLE);
            $blueprint
                ->json(Block::NAME);
            $blueprint
                ->boolean(Block::COLLAPSIBLE)
                ->default(false);
            $blueprint
                ->timestamps();
        });
    }

    /**
     * @return void
     */
    private function createBlockSetTable(): void
    {
        Schema::create(BlockSet::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->id(BlockSet::ID);
            $blueprint
                ->foreignId(BlockSet::BLOCK_ID)
                ->constrained(Block::TABLE, Block::ID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(BlockSet::SET_ID)
                ->constrained(Block::TABLE, Block::ID)
                ->cascadeOnDelete();
        });
    }

    #endregion
};
