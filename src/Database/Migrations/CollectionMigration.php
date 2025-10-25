<?php

namespace Narsil\Database\Migrations;

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityBlock;
use Narsil\Models\Entities\EntityBlockField;
use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class CollectionMigration extends Migration
{
    #region CONSTRUCTOR

    /**
     * @param Template $template
     *
     * @return void
     */
    public function __construct(Template $template)
    {
        Entity::setTemplate($template);
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * Run the migrations.
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
        if (!Schema::hasTable(EntityBlockField::getTableName()))
        {
            $this->createEntityBlockFieldsTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(EntityBlockField::getTableName());
        Schema::dropIfExists(EntityBlock::getTableName());
        Schema::dropIfExists(Entity::getTableName());
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Create the entities table.
     *
     * @return void
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
                ->default(1)
                ->index();
            $blueprint
                ->boolean(Entity::PUBLISHED)
                ->default(false)
                ->index();
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
     * Create the entity blocks table.
     *
     * @return void
     */
    protected function createEntityBlocksTable(): void
    {
        Schema::create(EntityBlock::getTableName(), function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(EntityBlock::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(EntityBlock::ENTITY_UUID)
                ->constrained(Entity::getTableName(), Entity::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->uuid(EntityBlock::PARENT_UUID)
                ->nullable();
            $blueprint
                ->foreignId(EntityBlock::BLOCK_ID)
                ->constrained(Block::TABLE, Block::ID)
                ->cascadeOnDelete();
            $blueprint
                ->integer(EntityBlock::POSITION)
                ->default(0);
        });

        Schema::table(EntityBlock::getTableName(), function (Blueprint $blueprint)
        {
            $blueprint
                ->foreign(EntityBlock::PARENT_UUID)
                ->references(EntityBlock::UUID)
                ->on(EntityBlock::getTableName())
                ->nullOnDelete();
        });
    }

    /**
     * Create the entity block fields table.
     *
     * @return void
     */
    protected function createEntityBlockFieldsTable(): void
    {
        Schema::create(EntityBlockField::getTableName(), function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(EntityBlockField::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(EntityBlockField::BLOCK_UUID)
                ->constrained(EntityBlock::getTableName(), EntityBlock::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(EntityBlockField::FIELD_ID)
                ->constrained(Field::TABLE, Field::ID)
                ->cascadeOnDelete();
            $blueprint
                ->jsonb(EntityBlockField::VALUE)
                ->nullable();
        });
    }

    #endregion
};
