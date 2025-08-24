<?php

namespace Narsil\Database\Migrations;

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Elements\Block;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityBlock;
use Narsil\Models\User;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class CollectionMigration extends Migration
{
    #region CONSTRUCTOR

    /**
     * @param string $table
     *
     * @return void
     */
    public function __construct(string $table)
    {
        Entity::setTableName($table);
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    public function up(): void
    {
        if (!Schema::hasTable(Entity::getTableName()))
        {
            $this->createEntitiesTable();
        }
        if (!Schema::hasTable(EntityBlock::getTableName()))
        {
            $this->createEntityBlocksTable();
        }
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(EntityBlock::getTableName());
        Schema::dropIfExists(Entity::getTableName());
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function createEntitiesTable(): void
    {
        Schema::create(Entity::getTableName(), function (Blueprint $table)
        {
            $table
                ->uuid(Entity::UUID)
                ->primary();
            $table
                ->bigInteger(Entity::ID)
                ->index();
            $table
                ->bigInteger(Entity::REVISION)
                ->default(1);
            $table
                ->timestamp(Entity::CREATED_AT);
            $table
                ->foreignId(Entity::CREATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
            $table
                ->timestamp(Entity::UPDATED_AT);
            $table
                ->foreignId(Entity::UPDATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
            $table
                ->softDeletes()
                ->index();
            $table
                ->foreignId(Entity::DELETED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
        });
    }

    /**
     * {@inheritDoc}
     */
    protected function createEntityBlocksTable(): void
    {
        Schema::create(EntityBlock::getTableName(), function (Blueprint $table)
        {
            $table
                ->id(EntityBlock::ID);
            $table
                ->foreignUuid(EntityBlock::ENTITY_UUID)
                ->constrained(Entity::getTableName(), Entity::UUID)
                ->cascadeOnDelete();
            $table
                ->foreignId(EntityBlock::PARENT_ID)
                ->nullable()
                ->constrained(EntityBlock::getTableName(), EntityBlock::ID)
                ->nullOnDelete();
            $table
                ->foreignId(EntityBlock::BLOCK_ID)
                ->constrained(Block::TABLE, Block::ID)
                ->cascadeOnDelete();
            $table
                ->integer(EntityBlock::POSITION)
                ->default(0);
            $table
                ->json(EntityBlock::VALUES)
                ->nullable();
        });
    }

    #endregion
};
