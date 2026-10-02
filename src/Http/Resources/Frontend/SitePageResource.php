<?php

declare(strict_types=1);

namespace Narsil\Cms\Http\Resources\Frontend;

#region USE

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Narsil\Cms\Form\Http\Resources\Frontend\FormResource;
use Narsil\Cms\Form\Models\Form;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Element;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Models\Entities\EntityNode;
use Narsil\Cms\Models\Entities\EntityNodeRelation;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Models\Sites\SitePageEntity;
use Narsil\Cms\Models\Sites\SiteUrl;

#endregion

class SitePageResource extends JsonResource
{
    #region PROPERTIES

    /**
     * @var Collection<string,EntityNode>
     */
    protected Collection $nodes;

    #endregion

    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return array<string,mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'change_freq' => $this->resource->{SitePage::CHANGE_FREQ},
            'data' => $this->resolveData($request),
            'id' => $this->resource->{SitePage::ID},
            'meta_description' => $this->resource->{SitePage::META_DESCRIPTION},
            'open_graph_description' => $this->resource->{SitePage::OPEN_GRAPH_DESCRIPTION},
            'open_graph_image' => $this->resource->{SitePage::OPEN_GRAPH_IMAGE},
            'open_graph_title' => $this->resource->{SitePage::OPEN_GRAPH_TITLE},
            'open_graph_type' => $this->resource->{SitePage::OPEN_GRAPH_TYPE},
            'priority' => $this->resource->{SitePage::PRIORITY},
            'robots' => $this->resource->{SitePage::ROBOTS},
            'slug' => $this->resource->{SitePage::SLUG},
            'title' => $this->resource->{SitePage::TITLE},
            'urls' => $this->getUrls($request),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param array $data
     * @param string|null $parentUuid
     * @param string|null $path
     * @param Request $request
     *
     * @return array
     */
    protected function processNodes(array $data, ?string $parentUuid, ?string $path, Request $request): array
    {
        foreach ($this->nodes->get($parentUuid, []) as $node)
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
                    $realIndex = 0;

                    foreach ($blockNodes as $blockNode)
                    {
                        if ($blockNode->getTranslationWithFallback(EntityNode::ACTIVE, App::getLocale()) === false)
                        {
                            continue;
                        }

                        Arr::set($data, "$key.$realIndex", [
                            Block::HANDLE => $blockNode->{EntityNode::RELATION_BLOCK}->{Block::HANDLE},
                            EntityNode::BLOCK_ID => $blockNode->{EntityNode::BLOCK_ID},
                            EntityNode::UUID => $blockNode->{EntityNode::UUID},
                        ]);
                        $nextPath = "$key.$realIndex." . EntityNode::RELATION_CHILDREN;
                        $data = $this->processNodes($data, $blockNode->{EntityNode::UUID}, $nextPath, $request);
                        $realIndex++;
                    }
                }
                elseif ($node->{EntityNode::RELATION_RELATIONS}->count() > 0)
                {
                    $relation = $node->{EntityNode::RELATION_RELATIONS}->first();

                    Arr::set($data, $key, $this->getRelationValue($relation, $request));
                }
                else
                {
                    Arr::set($data, $key, $node->{EntityNode::VALUE});
                }
            }
            else
            {
                $block = $element->{Element::RELATION_BASE};
                $nextPath = $block->{Block::VIRTUAL} ? $path : ($path ? "$path.$handle" : $handle);
                $data = $this->processNodes($data, $node->{EntityNode::UUID}, $nextPath, $request);
            }
        }

        return $data;
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    protected function resolveData(Request $request): array
    {
        $entities = $this->resource->{SitePage::RELATION_ENTITIES}->keyBy(SitePageEntity::LANGUAGE);
        $entity = $entities->get(App::getLocale(), $entities->get(Config::get('app.fallback_locale')))?->{SitePageEntity::RELATION_TARGET};

        if (!$entity)
        {
            return [];
        }

        $nodes = $entity->{Entity::RELATION_NODES};

        $nodes->loadMissing([
            EntityNode::RELATION_BLOCK,
            EntityNode::RELATION_ELEMENT,
            EntityNode::RELATION_RELATIONS,
        ]);

        $this->nodes = $nodes->groupBy(EntityNode::PARENT_UUID);

        return $this->processNodes([], null, null, $request);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @param EntityNodeRelation $relation
     * @param Request $request
     *
     * @return mixed
     */
    private function getRelationValue(EntityNodeRelation $relation, Request $request): mixed
    {
        $target = $relation->{EntityNodeRelation::RELATION_TARGET};

        if (class_exists(Form::class) && $relation->{EntityNodeRelation::TARGET_TYPE} === Form::TABLE)
        {
            $target = new FormResource($target)
                ->toArray($request);
        }
        elseif ($relation->{EntityNodeRelation::TARGET_TYPE} === SitePage::TABLE)
        {
            $target = new SiteUrlResource($target->{SitePage::RELATION_URL})
                ->toArray($request);
        }

        return $target;
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    private function getUrls(Request $request): array
    {
        return $this->resource->{SitePage::RELATION_URLS}->map(function (SiteUrl $url) use ($request): array
        {
            return new SiteUrlResource($url)
                ->toArray($request);
        })->all();
    }

    #endregion
}
