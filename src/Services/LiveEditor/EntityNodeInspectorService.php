<?php

namespace Narsil\Cms\Services\LiveEditor;

#region USE

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Narsil\Base\Http\Data\Forms\FieldData as BaseFieldData;
use Narsil\Cms\Http\Data\Forms\FieldData;
use Narsil\Cms\Http\Data\Forms\FieldsetData;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Element;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Models\Entities\EntityNode;
use Narsil\Cms\Models\Entities\EntityNodeRelation;

#endregion

class EntityNodeInspectorService
{
    #region PROPERTIES

    /**
     * The values of the node keyed by field path.
     *
     * @var array
     */
    private array $data = [];

    /**
     * The nodes of the entity grouped by parent uuid.
     *
     * @var Collection<string,Collection<integer,EntityNode>>
     */
    private Collection $nodes;

    /**
     * The relation options keyed by field path.
     *
     * @var array
     */
    private array $options = [];

    #endregion

    #region PUBLIC METHODS

    /**
     * Build the inspector schema and values of a block node.
     *
     * Builder fields are left out since the blocks they hold are managed
     * through the content tree instead.
     *
     * @param Entity $entity
     * @param EntityNode $node
     *
     * @return array
     */
    public function build(Entity $entity, EntityNode $node): array
    {
        $nodes = $entity->{Entity::RELATION_NODES};

        $nodes->loadMissing([
            EntityNode::RELATION_BLOCK,
            EntityNode::RELATION_ELEMENT,
            EntityNode::RELATION_RELATIONS,
        ]);

        $node->loadMissing([
            EntityNode::RELATION_BLOCK,
        ]);

        $block = $node->{EntityNode::RELATION_BLOCK};

        $this->data = [];
        $this->nodes = $nodes->groupBy(EntityNode::PARENT_UUID);
        $this->options = [];

        $elements = $this->processElements(
            $block->{Block::RELATION_ELEMENTS},
            $node->{EntityNode::UUID},
        );

        return [
            'blockId' => $node->{EntityNode::BLOCK_ID},
            'data' => $this->data,
            'elements' => $elements,
            'label' => $block->{Block::LABEL},
            'nodeUuid' => $node->{EntityNode::UUID},
            'options' => $this->options,
        ];
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @param Collection $elements
     * @param string|null $parentUuid
     * @param string|null $path
     *
     * @return array
     */
    private function processElements(Collection $elements, ?string $parentUuid, ?string $path = null): array
    {
        $childNodes = $this->childNodesByHandle($parentUuid);

        $fields = [];

        foreach ($elements as $element)
        {
            $handle = $element->{Element::HANDLE};

            $key = $path ? "$path.$handle" : $handle;

            $childNode = $childNodes->get($handle);

            if ($element->{Element::BASE_TYPE} === Field::TABLE)
            {
                $field = $element->{Element::RELATION_BASE};

                if ($field->{Field::TYPE} === EntityNodeTreeService::TYPE_BUILDER)
                {
                    continue;
                }

                if ($childNode)
                {
                    $this->setValue($element, $childNode, $key);
                }

                $fields[] = FieldData::fromElement($element)
                    // The inspector is a narrow panel, so the column widths of
                    // the regular form layout are dropped for a single column.
                    ->set(BaseFieldData::WIDTH, 100);

                continue;
            }

            $base = $element->{Element::RELATION_BASE};

            $fieldset = FieldsetData::fromElement($element);

            $fieldset->set(FieldsetData::ELEMENTS, $this->processElements(
                $base->{Block::RELATION_ELEMENTS},
                $childNode?->{EntityNode::UUID},
                $key,
            ));

            $fields[] = $fieldset;
        }

        return $fields;
    }

    /**
     * @param string|null $parentUuid
     *
     * @return Collection<string,EntityNode>
     */
    private function childNodesByHandle(?string $parentUuid): Collection
    {
        if (!$parentUuid)
        {
            return collect();
        }

        return $this->nodes
            ->get($parentUuid, collect())
            ->filter(function (EntityNode $node)
            {
                return $node->{EntityNode::RELATION_ELEMENT} !== null;
            })
            ->keyBy(function (EntityNode $node)
            {
                return $node->{EntityNode::RELATION_ELEMENT}->{Element::HANDLE};
            });
    }

    /**
     * @param Element $element
     * @param EntityNode $node
     * @param string $key
     *
     * @return void
     */
    private function setValue(Element $element, EntityNode $node, string $key): void
    {
        $relations = $node->{EntityNode::RELATION_RELATIONS};

        if (count($relations) > 0)
        {
            $this->options[$key] = $relations
                ->map(function (EntityNodeRelation $relation)
                {
                    return $relation->{EntityNodeRelation::RELATION_TARGET}?->toOption();
                })
                ->filter()
                ->values()
                ->all();
        }

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

    #endregion
}
