<?php

namespace Narsil\Implementations\Resources;

#region USE

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Narsil\Contracts\Fields\BuilderField;
use Narsil\Contracts\Resources\EntityResource as Contract;
use Narsil\Implementations\AbstractResource;
use Narsil\Interfaces\IStructureHasElement;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityNode;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityResource extends AbstractResource implements Contract
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(mixed $resource)
    {
        $nodes = $resource->{Entity::RELATION_NODES};

        $nodes->loadMissing([
            EntityNode::RELATION_ELEMENT,
        ]);

        $this->nodes = $nodes->groupBy(EntityNode::PARENT_UUID);

        return parent::__construct($resource);
    }

    #endregion

    #region PROPERTIES

    /**
     * The nodes of the entity grouped by parent uuid.
     *
     * @var Collection<string,EntityNode>
     */
    protected readonly Collection $nodes;

    /**
     * @var array
     */
    protected array $data = [];

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        $this->data = [
            Entity::ID => $this->{Entity::ID},
            Entity::SLUG => $this->getTranslations(Entity::SLUG),
            Entity::UUID => $this->{Entity::UUID},

            Entity::ATTRIBUTE_HAS_DRAFT => $this->{Entity::ATTRIBUTE_HAS_DRAFT},
            Entity::ATTRIBUTE_HAS_NEW_REVISION => $this->{Entity::ATTRIBUTE_HAS_NEW_REVISION},
            Entity::ATTRIBUTE_HAS_PUBLISHED_REVISION => $this->{Entity::ATTRIBUTE_HAS_PUBLISHED_REVISION},
        ];

        $this->processNodes();

        return $this->data;
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param string|null $parentUuid
     * @param string|null $path
     *
     * @return void
     */
    protected function processNodes(?string $parentUuid = null, ?string $path = null): void
    {
        $nodes = $this->nodes->get($parentUuid, []);

        foreach ($nodes as $node)
        {
            $element = $node->{EntityNode::RELATION_ELEMENT};

            $handle = $element->{IStructureHasElement::HANDLE};

            if ($element->{IStructureHasElement::ELEMENT_TYPE} === Field::TABLE)
            {
                $field = $element->{IStructureHasElement::RELATION_ELEMENT};

                $key = $path ? "$path.$handle" : $handle;

                if ($field->{Field::TYPE} === BuilderField::class)
                {
                    $blockNodes = $this->nodes->get($node->{EntityNode::UUID}, []);

                    foreach ($blockNodes as $index => $blockNode)
                    {
                        Arr::set($this->data, "$key.$index", [
                            EntityNode::BLOCK_ID => $blockNode->{EntityNode::BLOCK_ID},
                        ]);

                        $nextPath = "$key.$index." . EntityNode::RELATION_CHILDREN;

                        $this->processNodes($blockNode->{EntityNode::UUID}, $nextPath);
                    }
                }
                else
                {
                    if ($element->{IStructureHasElement::TRANSLATABLE})
                    {
                        $value = $node->getTranslations(EntityNode::VALUE);
                    }
                    else
                    {
                        $value = $node->{EntityNode::VALUE};
                    }

                    Arr::set($this->data, $key, $value);
                }
            }
            else
            {
                $block = $element->{IStructureHasElement::RELATION_ELEMENT};

                if ($block->{Block::VIRTUAL})
                {
                    $nextPath = $path;
                }
                else
                {
                    $nextPath = $path ? "$path.$handle" : $handle;
                }

                $this->processNodes($node->{EntityNode::UUID}, $nextPath);
            }
        }
    }

    #endregion
}
