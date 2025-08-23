<?php

namespace Narsil\Database\Migrations;

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Narsil\Models\Elements\Block;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityElement;
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
     * @param string $table
     *
     * @return void
     */
    public function __construct(string $table)
    {
        $singular = Str::singular($table);
        $plural = Str::plural($table);

        $this->entities_table =  $plural;
        $this->entity_elements_table = $singular . '_elements';
    }

    #endregion

    #region PROPERTIES

    /**
     * @var string
     */
    protected readonly string $entities_table;
    /**
     * @var string
     */
    protected readonly string $entity_elements_table;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    public function up(): void
    {
        if (!Schema::hasTable($this->entities_table))
        {
            $this->createEntitiesTable();
        }
        if (!Schema::hasTable($this->entity_elements_table))
        {
            $this->createEntityElementsTable();
        }
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists($this->entity_elements_table);
        Schema::dropIfExists($this->entities_table);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function createEntitiesTable(): void
    {
        Schema::create($this->entities_table, function (Blueprint $table)
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
    protected function createEntityElementsTable(): void
    {
        Schema::create($this->entity_elements_table, function (Blueprint $table)
        {
            $table
                ->id(EntityElement::ID);
            $table
                ->foreignUuid(EntityElement::ENTITY_UUID)
                ->constrained($this->entities_table, Entity::UUID)
                ->cascadeOnDelete();
            $table
                ->foreignId(EntityElement::PARENT_ID)
                ->nullable()
                ->constrained($this->entity_elements_table, EntityElement::ID)
                ->nullOnDelete();
            $table
                ->foreignId(EntityElement::BLOCK_ID)
                ->constrained(Block::TABLE, Block::ID)
                ->cascadeOnDelete();
            $table
                ->integer(EntityElement::POSITION)
                ->default(0);
            $table
                ->json(EntityElement::VALUES)
                ->nullable();
        });
    }

    #endregion
};
