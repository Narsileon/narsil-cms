import { arrayMove } from "@dnd-kit/sortable";
import { compact, debounce } from "lodash";
import { DataTableContext, DataTableContextProps } from "./data-table-context";
import { getCoreRowModel, useReactTable } from "@tanstack/react-table";
import { restrictToHorizontalAxis } from "@dnd-kit/modifiers";
import { router } from "@inertiajs/react";
import { useCallback, useEffect, useMemo } from "react";
import useDataTableStore from "@narsil-cms/stores/data-table-store";
import {
  closestCenter,
  DndContext,
  KeyboardSensor,
  MouseSensor,
  TouchSensor,
  useSensor,
  useSensors,
} from "@dnd-kit/core";
import type { DataTableStoreType } from "@narsil-cms/stores/data-table-store";
import type { DragEndEvent } from "@dnd-kit/core";
import type {
  ColumnDef,
  ColumnOrderState,
  ColumnSizingState,
  PaginationState,
  SortingState,
  TableOptions,
  Updater,
  VisibilityState,
} from "@tanstack/react-table";

type DataTableProviderProps = Partial<TableOptions<any>> & {
  columns: ColumnDef<any>[];
  data: any[];
  id: string;
  initialState: Partial<DataTableStoreType>;
  render: (context: DataTableContextProps) => React.ReactNode;
};

function formatSorting(sorting: SortingState) {
  return Object.fromEntries(
    sorting.map(({ id, desc }) => [id, desc ? "desc" : "asc"]),
  );
}

function DataTableProvider({
  columns,
  data,
  id,
  initialState = {},
  render,
  ...props
}: DataTableProviderProps) {
  const columnOrder = compact(columns.map((c) => c.id));

  const createDataTableStore = useMemo(
    () =>
      useDataTableStore({
        id: id,
        initialState: {
          columnOrder: columnOrder,
          ...initialState,
        },
      }),
    [id, initialState],
  );

  const dataTableStore = createDataTableStore((state) => state);

  const sensors = useSensors(
    useSensor(MouseSensor, {}),
    useSensor(TouchSensor, {}),
    useSensor(KeyboardSensor, {}),
  );

  function handleColumnOrderChange(
    order: Updater<ColumnOrderState> | ColumnOrderState,
  ) {
    dataTableStore.setColumnOrder(
      typeof order === "function" ? order(dataTableStore.columnOrder) : order,
    );
  }

  function handleColumnSizingChange(
    sizing: Updater<ColumnSizingState> | ColumnSizingState,
  ) {
    dataTableStore.setColumnSizing(
      typeof sizing === "function"
        ? sizing(dataTableStore.columnSizing)
        : sizing,
    );
  }

  function handleColumnVisibilityChange(
    visibility: Updater<VisibilityState> | VisibilityState,
  ) {
    dataTableStore.setColumnVisibility(
      typeof visibility === "function"
        ? visibility(dataTableStore.columnVisibility)
        : visibility,
    );
  }

  function handlePaginationChange(
    pagination: Updater<PaginationState> | PaginationState,
  ) {
    dataTableStore.setPagination(
      typeof pagination === "function"
        ? pagination({
            pageIndex: dataTableStore.pageIndex,
            pageSize: dataTableStore.pageSize,
          })
        : pagination,
    );
  }

  function handleSortingChange(sorting: Updater<SortingState> | SortingState) {
    dataTableStore.setSorting(
      typeof sorting === "function" ? sorting(dataTableStore.sorting) : sorting,
    );
  }

  const dataTable = useReactTable({
    columnResizeMode: "onEnd",
    columns: columns,
    data: data,
    enableColumnFilters: false,
    enableColumnResizing: true,
    enableExpanding: false,
    enableFilters: true,
    enableGlobalFilter: true,
    enableGrouping: false,
    enableHiding: true,
    enableMultiRowSelection: true,
    enableMultiSort: true,
    enableRowSelection: true,
    enableSorting: true,
    groupedColumnMode: false,
    manualExpanding: true,
    manualFiltering: true,
    manualGrouping: false,
    manualPagination: true,
    manualSorting: true,
    state: {
      columnOrder: dataTableStore.columnOrder,
      columnSizing: dataTableStore.columnSizing,
      columnVisibility: dataTableStore.columnVisibility,
      globalFilter: dataTableStore.search,
      pagination: {
        pageIndex: dataTableStore.pageIndex,
        pageSize: dataTableStore.pageSize,
      },
      sorting: dataTableStore.sorting,
    },
    getCoreRowModel: getCoreRowModel(),
    getRowId: (row: any) => row.id,
    onColumnOrderChange: handleColumnOrderChange,
    onColumnSizingChange: handleColumnSizingChange,
    onColumnVisibilityChange: handleColumnVisibilityChange,
    onGlobalFilterChange: dataTableStore.setSearch,
    onPaginationChange: handlePaginationChange,
    onSortingChange: handleSortingChange,
    ...props,
  });

  function handleDragEnd(event: DragEndEvent) {
    const { active, over } = event;

    if (!active || !over || active.id === over.id) {
      return;
    }

    if (
      active.id.toString().startsWith("_") ||
      over.id.toString().startsWith("_")
    ) {
      return;
    }

    dataTable.setColumnOrder((columnOrder) => {
      const activeIndex = columnOrder.indexOf(active.id as string);
      const overIndex = columnOrder.indexOf(over.id as string);

      return arrayMove(columnOrder, activeIndex, overIndex);
    });
  }

  const update = useCallback(
    debounce((href, params) => {
      router.get(href, params, {
        preserveScroll: true,
        preserveState: true,
      });
    }, 300),
    [router],
  );

  useEffect(() => {
    const href = window.location.origin + window.location.pathname;

    update(href, {
      filter: dataTableStore.filter,
      pageSize: dataTableStore.pageSize,
      search: dataTableStore.search,
      sorting: formatSorting(dataTableStore.sorting),
    });

    return () => update.cancel();
  }, [
    dataTableStore.filter,
    dataTableStore.pageSize,
    dataTableStore.search,
    JSON.stringify(dataTableStore.sorting),
  ]);

  return (
    <DataTableContext.Provider
      value={{
        dataTable: dataTable,
        dataTableStore: dataTableStore,
      }}
    >
      <DndContext
        collisionDetection={closestCenter}
        modifiers={[restrictToHorizontalAxis]}
        onDragEnd={handleDragEnd}
        sensors={sensors}
      >
        {render({ dataTable: dataTable, dataTableStore: dataTableStore })}
      </DndContext>
    </DataTableContext.Provider>
  );
}

export default DataTableProvider;
