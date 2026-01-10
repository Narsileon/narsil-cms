<?php

namespace Narsil\Database\Migrations;

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Collections\Block;
use Narsil\Models\Collections\BlockElement;
use Narsil\Models\Collections\Template;
use Narsil\Models\Collections\TemplateTabElement;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityNode;
use Narsil\Models\Entities\EntityNodeRelation;
use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateMigration extends Migration
{
    #region CONSTRUCTOR

    /**
     * @param Template $template
     *
     * @return void
     */
    public function __construct(Template $template)
    {
        $this->entityTable = $template->entityTable();
        $this->entityNodeTable = $template->entityNodeTable();
        $this->entityNodeRelationTable = $template->entityNodeRelationTable();
    }

    #endregion

    #region PROPERTIES

    /**
     * The name of the "entities" table.
     *
     * @var string
     */
    protected readonly string $entityTable;

    /**
     * The name of the "entity node entity" table.
     *
     * @var string
     */
    protected readonly string $entityNodeRelationTable;

    /**
     * The name of the "entity nodes" table.
     *
     * @var string
     */
    protected readonly string $entityNodeTable;

    #endregion

    #region PUBLIC METHODS

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        if (!Schema::hasTable($this->entityTable))
        {
            $this->createEntitiesTable();
        }
        if (!Schema::hasTable($this->entityNodeTable))
        {
            $this->createEntityNodesTable();
        }
        if (!Schema::hasTable($this->entityNodeRelationTable))
        {
            $this->createEntityNodeRelationTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists($this->entityNodeRelationTable);
        Schema::dropIfExists($this->entityNodeTable);
        Schema::dropIfExists($this->entityTable);
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
        Schema::create($this->entityTable, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(Entity::UUID)
                ->primary();
            $blueprint
                ->bigInteger(Entity::ID)
                ->index();
            $blueprint
                ->foreignId(Entity::TEMPLATE_ID)
                ->constrained(Template::TABLE, Template::ID)
                ->cascadeOnDelete();
            $blueprint
                ->string(Entity::SLUG);
            $blueprint
                ->bigInteger(Entity::REVISION)
                ->default(1)
                ->index();
            $blueprint
                ->boolean(Entity::PUBLISHED)
                ->default(false)
                ->index();
            $blueprint
                ->dateTime(Entity::PUBLISHED_FROM)
                ->nullable();
            $blueprint
                ->dateTime(Entity::PUBLISHED_TO)
                ->nullable();
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
     * Create the entity node relation table.
     *
     * @return void
     */
    protected function createEntityNodeRelationTable(): void
    {
        Schema::create($this->entityNodeRelationTable, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(EntityNodeRelation::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(EntityNodeRelation::OWNER_UUID)
                ->constrained($this->entityTable, Entity::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignUuid(EntityNodeRelation::OWNER_NODE_UUID)
                ->constrained($this->entityNodeTable, EntityNode::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->string(EntityNodeRelation::LANGUAGE);
            $blueprint
                ->morphs(EntityNodeRelation::RELATION_TARGET);
        });
    }

    /**
     * Create the entity nodes table.
     *
     * @return void
     */
    protected function createEntityNodesTable(): void
    {
        Schema::create($this->entityNodeTable, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(EntityNode::UUID)
                ->primary();
            $blueprint
                ->foreignUuid(EntityNode::OWNER_UUID)
                ->constrained($this->entityTable, Entity::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->uuid(EntityNode::PARENT_UUID)
                ->nullable();
            $blueprint
                ->nullableUuidMorphs(EntityNode::RELATION_ELEMENT);
            $blueprint
                ->foreignUuid(EntityNode::BLOCK_ELEMENT_UUID)
                ->nullable()
                ->constrained(BlockElement::TABLE, BlockElement::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignUuid(EntityNode::TEMPLATE_TAB_ELEMENT_UUID)
                ->nullable()
                ->foreignUuid(TemplateTabElement::TABLE, TemplateTabElement::UUID)
                ->cascadeOnDelete();
            $blueprint
                ->foreignId(EntityNode::BLOCK_ID)
                ->nullable()
                ->constrained(Block::TABLE, Block::ID)
                ->cascadeOnDelete();
            $blueprint
                ->integer(EntityNode::POSITION)
                ->default(0);
            $blueprint
                ->string(EntityNode::PATH)
                ->nullable();
            $blueprint
                ->jsonb(EntityNode::VALUE)
                ->nullable();
        });

        Schema::table($this->entityNodeTable, function (Blueprint $blueprint)
        {
            $blueprint
                ->foreign(EntityNode::PARENT_UUID)
                ->references(EntityNode::UUID)
                ->on($this->entityNodeTable)
                ->cascadeOnDelete();
        });
    }

    #endregion
};
