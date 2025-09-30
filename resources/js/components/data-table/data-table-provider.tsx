import { router } from "@inertiajs/react";
import {
  getCoreRowModel,
  useReactTable,
  type ColumnDef,
  type ColumnOrderState,
  type ColumnSizingState,
  type PaginationState,
  type SortingState,
  type TableOptions,
  type Updater,
  type VisibilityState,
} from "@tanstack/react-table";
import { debounce } from "lodash";
import { useCallback, useEffect, useMemo, type ReactNode } from "react";

import {
  useDataTableStore,
  type DataTableStoreType,
} from "@narsil-cms/stores/data-table-store";
import type { BaseModel } from "@narsil-cms/types";

import { DataTableContext } from "./data-table-context";

type DataTableProviderProps = Partial<
  Omit<TableOptions<BaseModel>, "columns">
> & {
  children: ReactNode;
  columns: ColumnDef<BaseModel>[];
  data: BaseModel[];
  id: string;
  initialState: Partial<DataTableStoreType>;
};

function formatSorting(sorting: SortingState) {
  return Object.fromEntries(
    sorting.map(({ id, desc }) => [id, desc ? "desc" : "asc"]),
  );
}

function DataTableProvider({
  children,
  columnResizeMode = "onEnd",
  columns,
  data,
  enableColumnFilters = false,
  enableColumnResizing = true,
  enableExpanding = false,
  enableFilters = true,
  enableGlobalFilter = true,
  enableGrouping = false,
  enableHiding = true,
  enableMultiRowSelection = true,
  enableMultiSort = true,
  enableRowSelection = true,
  enableSorting = true,
  groupedColumnMode = false,
  manualExpanding = true,
  manualFiltering = true,
  manualGrouping = false,
  manualPagination = true,
  manualSorting = true,
  id,
  initialState = {},
}: DataTableProviderProps) {
  const createDataTableStore = useMemo(
    () =>
      useDataTableStore({
        id: id,
        initialState: {
          ...initialState,
        },
      }),
    [id, initialState],
  );

  const dataTableStore = createDataTableStore((state) => state);

  if (
    initialState.columnOrder &&
    dataTableStore.columnOrder.length < (initialState.columnOrder?.length ?? 0)
  ) {
    dataTableStore.setColumnOrder(initialState.columnOrder);
  }

  if (
    initialState.columnVisibility &&
    dataTableStore.columnVisibility.length <
      (initialState.columnVisibility?.length ?? 0)
  ) {
    dataTableStore.setColumnVisibility(initialState.columnVisibility);
  }

  function handleColumnOrderChange(
    order: Updater<ColumnOrderState> | ColumnOrderState,
  ) {
    dataTableStore.setColumnOrder(
      typeof order === "function"
        ? order(dataTableStore.columnOrder ?? [])
        : order,
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

  const dataTable = useReactTable<BaseModel>({
    columnResizeMode: columnResizeMode,
    columns: columns,
    data: data,
    enableColumnFilters: enableColumnFilters,
    enableColumnResizing: enableColumnResizing,
    enableExpanding: enableExpanding,
    enableFilters: enableFilters,
    enableGlobalFilter: enableGlobalFilter,
    enableGrouping: enableGrouping,
    enableHiding: enableHiding,
    enableMultiRowSelection: enableMultiRowSelection,
    enableMultiSort: enableMultiSort,
    enableRowSelection: enableRowSelection,
    enableSorting: enableSorting,
    groupedColumnMode: groupedColumnMode,
    manualExpanding: manualExpanding,
    manualFiltering: manualFiltering,
    manualGrouping: manualGrouping,
    manualPagination: manualPagination,
    manualSorting: manualSorting,
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
    getRowId: (row) => row.id.toString(),
    onColumnOrderChange: handleColumnOrderChange,
    onColumnSizingChange: handleColumnSizingChange,
    onColumnVisibilityChange: handleColumnVisibilityChange,
    onGlobalFilterChange: dataTableStore.setSearch,
    onPaginationChange: handlePaginationChange,
    onSortingChange: handleSortingChange,
  });

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
      filters: JSON.stringify(dataTableStore.filters),
      pageSize: dataTableStore.pageSize,
      search: dataTableStore.search,
      sorting: formatSorting(dataTableStore.sorting),
    });

    return () => update.cancel();
  }, [
    dataTableStore.filter,
    JSON.stringify(dataTableStore.filters),
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
      {children}
    </DataTableContext.Provider>
  );
}

export default DataTableProvider;
