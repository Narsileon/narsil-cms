import { create } from "zustand";
import { createJSONStorage, persist } from "zustand/middleware";
import {
  ColumnOrderState,
  ColumnSizingState,
  PaginationState,
  SortingState,
  VisibilityState,
} from "@tanstack/react-table";
import type { FilterGroup } from "@narsil-cms/components/ui/filters";

type DataTableStoreState = {
  columnOrder: ColumnOrderState;
  columnSizing: ColumnSizingState;
  columnVisibility: VisibilityState;
  filter: string | null;
  filters: FilterGroup;
  pageIndex: number;
  pageSize: number;
  search: string | null;
  sorting: SortingState;
};

type DataTableStoreActions = {
  setColumnOrder: (columnOrder: ColumnOrderState) => void;
  setColumnSizing: (columnSizing: ColumnSizingState) => void;
  setColumnVisibility: (columnVisibility: VisibilityState) => void;
  setFilter: (filter: string | null) => void;
  setFilters: (filters: FilterGroup) => void;
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
        setFilters: (filters) =>
          set({
            filters: filters,
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
