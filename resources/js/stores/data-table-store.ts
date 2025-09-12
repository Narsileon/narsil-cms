import {
  type ColumnOrderState,
  type ColumnSizingState,
  type PaginationState,
  type SortingState,
  type VisibilityState,
} from "@tanstack/react-table";
import { create } from "zustand";
import { createJSONStorage, persist } from "zustand/middleware";

import { type ColumnFilter } from "@narsil-cms/components/data-table";

type DataTableStoreState = {
  columnOrder: ColumnOrderState;
  columnSizing: ColumnSizingState;
  columnVisibility: VisibilityState;
  filter: string | null;
  filters: ColumnFilter[];
  pageIndex: number;
  pageSize: number;
  search: string | null;
  sorting: SortingState;
};

type DataTableStoreActions = {
  addFilter: (column: string) => void;
  removeFilter: (column: string) => void;
  updateFilter: (column: string, attributes: Partial<ColumnFilter>) => void;
  setColumnOrder: (columnOrder: ColumnOrderState) => void;
  setColumnSizing: (columnSizing: ColumnSizingState) => void;
  setColumnVisibility: (columnVisibility: VisibilityState) => void;
  setFilter: (filter: string | null) => void;
  setPageIndex: (pageIndex: PaginationState["pageIndex"]) => void;
  setPageSize: (pageSige: PaginationState["pageSize"]) => void;
  setPagination: (pagination: PaginationState) => void;
  setSearch: (search: string | null) => void;
  setSorting: (sorting: SortingState) => void;
};

export type DataTableStoreType = DataTableStoreState & DataTableStoreActions;

type CreateDataTableStoreProps = {
  id: string;
  initialState?: Partial<DataTableStoreState>;
};

const defaultState: DataTableStoreState = {
  columnOrder: [],
  columnSizing: {},
  columnVisibility: {},
  filter: "",
  filters: [],
  pageIndex: 0,
  pageSize: 10,
  search: "",
  sorting: [],
};

const useDataTableStore = ({ id, initialState }: CreateDataTableStoreProps) =>
  create<DataTableStoreType>()(
    persist(
      (set) => ({
        ...defaultState,
        ...initialState,
        addFilter: (column) =>
          set((state) => ({
            filters: state.filters.some((filter) => filter.column === column)
              ? state.filters
              : [
                  ...state.filters,
                  {
                    column: column,
                    operator: "",
                    value: "",
                  },
                ],
          })),
        removeFilter: (column) =>
          set((state) => ({
            filters: state.filters.filter((filter) => filter.column !== column),
          })),
        updateFilter: (column, attributes) =>
          set((state) => ({
            filters: state.filters.map((filter) =>
              filter.column === column ? { ...filter, ...attributes } : filter,
            ),
          })),
        setColumnOrder: (columnOrder) =>
          set({
            columnOrder: columnOrder,
          }),
        setColumnSizing: (columnSizing) =>
          set({
            columnSizing: columnSizing,
          }),
        setColumnVisibility: (columnVisibility) =>
          set({
            columnVisibility: columnVisibility,
          }),
        setFilter: (filter) =>
          set({
            filter: filter,
          }),
        setPageIndex: (pageIndex) =>
          set({
            pageIndex: pageIndex,
          }),
        setPageSize: (pageSize) =>
          set({
            pageSize: pageSize,
          }),
        setPagination: (pagination) =>
          set({
            pageIndex: pagination.pageIndex,
            pageSize: pagination.pageSize,
          }),
        setSearch: (search) =>
          set({
            search: search,
          }),
        setSorting: (sorting) =>
          set({
            sorting: sorting,
          }),
      }),
      {
        name: `narsil-cms:tables:${id}`,
        storage: createJSONStorage(() => localStorage),
      },
    ),
  );

export default useDataTableStore;
