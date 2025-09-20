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
        Schema::create(Entity::getTableName(), function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(Entity::UUID)
                ->primary();
            $blueprint
                ->bigInteger(Entity::ID)
                ->index();
            $blueprint
                ->bigInteger(Entity::REVISION)
                ->default(1);
            $blueprint
                ->timestamp(Entity::CREATED_AT);
            $blueprint
                ->foreignId(Entity::CREATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
            $blueprint
                ->timestamp(Entity::UPDATED_AT);
            $blueprint
                ->foreignId(Entity::UPDATED_BY)
                ->nullable()
                ->constrained(User::TABLE, User::ID)
                ->nullOnDelete();
            $blueprint
                ->softDeletes()
                ->index();
            $blueprint
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
        Schema::create(EntityBlock::getTableName(), function (Blueprint $blueprint)
        {
            $blueprint
                ->id(EntityBlock::ID);
            $blueprint
                ->foreignUuid(EntityBlock::ENTITY_UUID)
                ->constrained(Entity::getTableName(), Entity::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(EntityBlock::PARENT_ID)
                ->nullable()
                ->constrained(EntityBlock::getTableName(), EntityBlock::ID)
                ->nullOnDelete();
            $blueprint
                ->foreignId(EntityBlock::BLOCK_ID)
                ->constrained(Block::TABLE, Block::ID)
                ->cascadeOnDelete();
            $blueprint
                ->integer(EntityBlock::POSITION)
                ->default(0);
            $blueprint
                ->json(EntityBlock::VALUES)
                ->nullable();
        });
    }

    #endregion
};
