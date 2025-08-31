<?php

#region USE

use Illuminate\Database\Migrations\Migration;
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
     * {@inheritDoc}
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
     * {@inheritDoc}
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
        Schema::create(BlockElementCondition::TABLE, function (Blueprint $table)
        {
            $table
                ->id(BlockElementCondition::ID);
            $table
                ->foreignId(BlockElementCondition::OWNER_ID)
                ->constrained(BlockElement::TABLE, BlockElement::ID)
                ->cascadeOnDelete();
            $table
                ->foreignId(BlockElementCondition::TARGET_ID)
                ->constrained(BlockElement::TABLE, BlockElement::ID)
                ->cascadeOnDelete();
            $table
                ->string(BlockElementCondition::OPERATOR);
            $table
                ->string(BlockElementCondition::VALUE);
            $table
                ->timestamps();
        });
    }

    /**
     * @return void
     */
    private function createBlockElementTable(): void
    {
        Schema::create(BlockElement::TABLE, function (Blueprint $table)
        {
            $table
                ->id(BlockElement::ID);
            $table
                ->foreignId(BlockElement::BLOCK_ID)
                ->constrained(Block::TABLE, Block::ID)
                ->cascadeOnDelete();
            $table
                ->morphs(BlockElement::RELATION_ELEMENT);
            $table
                ->string(BlockElement::HANDLE);
            $table
                ->string(BlockElement::NAME);
            $table
                ->string(BlockElement::DESCRIPTION)
                ->nullable();
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
    private function createBlocksTable(): void
    {
        Schema::create(Block::TABLE, function (Blueprint $table)
        {
            $table
                ->id(Block::ID);
            $table
                ->string(Block::HANDLE);
            $table
                ->string(Block::NAME);
            $table
                ->timestamps();
        });
    }

    /**
     * @return void
     */
    private function createBlockSetTable(): void
    {
        Schema::create(BlockSet::TABLE, function (Blueprint $table)
        {
            $table
                ->id(BlockSet::ID);
            $table
                ->foreignId(BlockSet::BLOCK_ID)
                ->constrained(Block::TABLE, Block::ID)
                ->cascadeOnDelete();
            $table
                ->foreignId(BlockSet::SET_ID)
                ->constrained(Block::TABLE, Block::ID)
                ->cascadeOnDelete();
        });
    }

    #endregion
};
