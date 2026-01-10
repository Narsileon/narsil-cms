<?php

namespace Narsil\Observers;

#region USE

use Narsil\Contracts\Fields\FormField;
use Narsil\Interfaces\ITemplateElement;
use Narsil\Models\Collections\BlockElement;
use Narsil\Models\Collections\Field;
use Narsil\Models\Collections\TemplateTabElement;
use Narsil\Models\Entities\EntityNode;
use Narsil\Models\Entities\EntityNodeRelation;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityNodeObserver
{
    #region PUBLIC METHODS

    /**
     * @param EntityNode $model
     *
     * @return void
     */
    public function saved(EntityNode $model): void
    {
        if ($model->{EntityNode::ELEMENT_TYPE})
        {
            $this->syncRelations($model);
        }
    }

    /**
     * @param EntityNode $model
     *
     * @return void
     */
    public function saving(EntityNode $model): void
    {
        match ($model->{EntityNode::ELEMENT_TYPE})
        {
            BlockElement::TABLE => $model->{EntityNode::BLOCK_ELEMENT_UUID} = $model->{EntityNode::ELEMENT_ID},
            TemplateTabElement::TABLE => $model->{EntityNode::TEMPLATE_TAB_ELEMENT_UUID} = $model->{EntityNode::ELEMENT_ID},
            default => null,
        };
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param EntityNode $entityNode
     *
     * @return void
     */
    protected function syncRelations(EntityNode $entityNode): void
    {
        $entityNode->loadMissing([
            EntityNode::RELATION_ELEMENT . '.' . ITemplateElement::RELATION_BASE,
        ]);

        $field = $entityNode->{EntityNode::RELATION_ELEMENT}?->{ITemplateElement::RELATION_BASE};

        if ($field->{Field::TYPE} === FormField::class)
        {
            $entityNode->entities()->delete();

            foreach ($entityNode->getTranslations(EntityNode::VALUE) as $language => $translation)
            {
                [$table, $id] = explode('-', $translation);

                $entityNode->entities()->create([
                    EntityNodeRelation::LANGUAGE => $language,
                    EntityNodeRelation::OWNER_UUID => $entityNode->{EntityNode::OWNER_UUID},
                    EntityNodeRelation::TARGET_ID  => $id,
                    EntityNodeRelation::TARGET_TYPE => $table,
                ]);
            }
        }
    }

    #endregion
}
