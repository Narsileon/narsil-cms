<?php

namespace Narsil\Http\Collections;

#region USE

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;
use JsonSerializable;
use Narsil\Contracts\Table;
use Narsil\Http\Requests\QueryRequest;
use Narsil\Services\QueryService;
use Narsil\Support\TranslationsBag;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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

    #region • FLUENT METHODS

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
            ->add('narsil::accessibility.first_page')
            ->add('narsil::accessibility.last_page')
            ->add('narsil::accessibility.more_pages')
            ->add('narsil::accessibility.move_column')
            ->add('narsil::accessibility.next_page')
            ->add('narsil::accessibility.previous_page')
            ->add('narsil::accessibility.sort_column')
            ->add('narsil::accessibility.toggle_row_menu')
            ->add('narsil::operators.after_or_equal')
            ->add('narsil::operators.after')
            ->add('narsil::operators.before_or_equal')
            ->add('narsil::operators.before')
            ->add('narsil::operators.contains')
            ->add('narsil::operators.doesnt_end_with')
            ->add('narsil::operators.doesnt_start_with')
            ->add('narsil::operators.ends_with')
            ->add('narsil::operators.equals')
            ->add('narsil::operators.greater_than_or_equal')
            ->add('narsil::operators.greater_than')
            ->add('narsil::operators.less_than_or_equal')
            ->add('narsil::operators.less_than')
            ->add('narsil::operators.not_contains')
            ->add('narsil::operators.not_equals')
            ->add('narsil::operators.starts_with')
            ->add('narsil::pagination.pages_count')
            ->add('narsil::pagination.pages_empty')
            ->add('narsil::pagination.pagination')
            ->add('narsil::pagination.selected_count')
            ->add('narsil::pagination.selected_empty')
            ->add('narsil::placeholders.search')
            ->add('narsil::ui.active_columns')
            ->add('narsil::ui.available_columns')
            ->add('narsil::ui.columns')
            ->add('narsil::ui.create')
            ->add('narsil::ui.delete')
            ->add('narsil::ui.delete_selected')
            ->add('narsil::ui.deselect_all')
            ->add('narsil::ui.duplicate')
            ->add('narsil::ui.duplicate_selected')
            ->add('narsil::ui.edit')
            ->add('narsil::ui.filters')
            ->add('narsil::ui.hide')
            ->add('narsil::ui.move')
            ->add('narsil::ui.show');
    }

    #endregion
}
