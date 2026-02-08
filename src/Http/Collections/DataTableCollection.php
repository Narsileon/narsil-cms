<?php

namespace Narsil\Cms\Http\Collections;

#region USE

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;
use JsonSerializable;
use Narsil\Cms\Contracts\Table;
use Narsil\Cms\Http\Requests\QueryRequest;
use Narsil\Cms\Services\QueryService;
use Narsil\Ui\Support\TranslationsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class DataTableCollection extends ResourceCollection
{
    #region CONSTUCTORS

    /**
     * @param Builder $query
     * @param string $table
     *
     * @return void
     */
    public function __construct(
        Builder $query,
        string $table,
    )
    {
        $template = app()->bound("tables.$table")
            ? app()->make("tables.$table", [
                'table' => $table,
            ])
            : app()->make('tables.entities', [
                'table' => $table,
            ]);

        $this->table = $template;

        if ($search = request(QueryRequest::SEARCH))
        {
            QueryService::applySearch($query, $table, $search);
        }

        if ($filters = request(QueryRequest::FILTERS))
        {
            QueryService::applyFilters($query, json_decode($filters, true));
        }

        if ($sorting = request(QueryRequest::SORTING))
        {
            QueryService::applySorting($query, $sorting);
        }

        $paginated = $query->paginate(
            perPage: request(self::PAGE_SIZE, 10),
            page: request(self::PAGE, 1),
        );

        parent::__construct($paginated);

        $this->registerLabels();
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string
     */
    public const PAGE = 'page';
    /**
     * @var string
     */
    public const PAGE_SIZE = 'pageSize';

    #endregion

    #region PROPERTIES

    /**
     * @var Table
     */
    protected readonly Table $table;

    /**
     * @var array<string,mixed>
     */
    protected array $options = [];

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): JsonSerializable
    {
        return $this->collection->map(function ($item)
        {
            return $item->toArray();
        });
    }

    /**
     * {@inheritDoc}
     */
    public function with($request): array
    {
        $meta = $this->getMeta();

        return array_merge([
            'columns' => $this->table->getColumns(),
            'columnOrder' => $this->table->getColumnOrder(),
            'columnVisibility' => $this->table->getColumnVisibility(),
            'meta' => $meta,
        ]);
    }

    #region • FLUENT

    /**
     * @param boolean $revisionable
     *
     * @return static
     */
    public function setRevisionable(bool $revisionable): static
    {
        $this->options['revisionable'] = $revisionable;

        if ($revisionable)
        {
            app(TranslationsBag::class)
                ->add('narsil-cms::revisions.draft')
                ->add('narsil-cms::revisions.published')
                ->add('narsil-cms::revisions.saved');
        }

        return $this;
    }

    /**
     * @param boolean $selectable
     *
     * @return static
     */
    public function setSelectable(bool $selectable): static
    {
        $this->options['selectable'] = $selectable;

        return $this;
    }

    #endregion

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<string,mixed>
     */
    protected function getMeta(): array
    {
        $id = Str::slug($this->table->name);

        return array_merge($this->options, [
            'id'     => $id,
            'routes' => $this->table->getRoutes(),
        ]);
    }

    /**
     * @return void
     */
    protected function registerLabels(): void
    {
        app(TranslationsBag::class)
            ->add('narsil-cms::accessibility.move_column')
            ->add('narsil-cms::accessibility.toggle_row_menu')
            ->add('narsil-cms::dialogs.descriptions.delete')
            ->add('narsil-cms::dialogs.titles.delete')
            ->add('narsil-cms::pagination.pages_count')
            ->add('narsil-cms::pagination.pages_empty')
            ->add('narsil-cms::pagination.pagination')
            ->add('narsil-cms::pagination.selected_count')
            ->add('narsil-cms::pagination.selected_empty')
            ->add('narsil-cms::ui.active_columns')
            ->add('narsil-cms::ui.available_columns')
            ->add('narsil-cms::ui.columns')
            ->add('narsil-cms::ui.create')
            ->add('narsil-cms::ui.delete_selected')
            ->add('narsil-cms::ui.delete')
            ->add('narsil-cms::ui.deselect_all')
            ->add('narsil-cms::ui.duplicate_selected')
            ->add('narsil-cms::ui.duplicate')
            ->add('narsil-cms::ui.edit')
            ->add('narsil-cms::ui.filters')
            ->add('narsil-cms::ui.hide')
            ->add('narsil-cms::ui.show')
            ->add('narsil-ui::pagination.first_page')
            ->add('narsil-ui::pagination.last_page')
            ->add('narsil-ui::pagination.more')
            ->add('narsil-ui::pagination.next_page')
            ->add('narsil-ui::pagination.previous_page')
            ->add('narsil-ui::placeholders.search')
            ->add('narsil-ui::tooltips.move')
            ->add('narsil-ui::tooltips.sort')
            ->add('narsil-ui::ui.cancel')
            ->add('narsil-ui::ui.confirm');
    }

    #endregion
}
