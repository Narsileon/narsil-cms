<?php

namespace Narsil\Cms\Implementations\Resources;

#region USE

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Narsil\Base\Implementations\Resource;
use Narsil\Cms\Contracts\Resources\EntityResource as Contract;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Element;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Models\Entities\EntityNode;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityResource extends Resource implements Contract
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

            $handle = $element->{Element::HANDLE};

            if ($element->{Element::BASE_TYPE} === Field::TABLE)
            {
                $field = $element->{Element::RELATION_BASE};

                $key = $path ? "$path.$handle" : $handle;

                if ($field->{Field::TYPE} === 'builder')
                {
                    $blockNodes = $this->nodes->get($node->{EntityNode::UUID}, []);

                    foreach ($blockNodes as $index => $blockNode)
                    {
                        Arr::set($this->data, "$key.$index", [
                            EntityNode::ACTIVE => $blockNode->getTranslations(EntityNode::ACTIVE),
                            EntityNode::BLOCK_ID => $blockNode->{EntityNode::BLOCK_ID},
                            EntityNode::UUID => $blockNode->{EntityNode::UUID},
                        ]);

                        $nextPath = "$key.$index." . EntityNode::RELATION_CHILDREN;

                        $this->processNodes($blockNode->{EntityNode::UUID}, $nextPath);
                    }
                }
                else
                {
                    if ($element->{Element::TRANSLATABLE})
                    {
                        $value = $node->getTranslations(EntityNode::VALUE);

                        if (empty($value))
                        {
                            $value = (object)[];
                        }
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
                $block = $element->{Element::RELATION_BASE};

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
