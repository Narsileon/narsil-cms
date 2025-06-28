import { create } from "zustand";
import { createJSONStorage, persist } from "zustand/middleware";
import {
  ColumnOrderState,
  ColumnSizingState,
  PaginationState,
  SortingState,
  VisibilityState,
} from "@tanstack/react-table";

export type DataTableStoreState = {
  columnOrder: ColumnOrderState;
  columnSizing: ColumnSizingState;
  columnVisibility: VisibilityState;
  globalFilter: string;
  pageIndex: number;
  pageSize: number;
  sorting: SortingState;
};

export type DataTableStoreActions = {
  setColumnOrder: (columnOrder: ColumnOrderState) => void;
  setColumnSizing: (columnSizing: ColumnSizingState) => void;
  setColumnVisibility: (columnVisibility: VisibilityState) => void;
  setGlobalFilter: (globalFilter: string) => void;
  setPageIndex: (pageIndex: PaginationState["pageIndex"]) => void;
  setPageSize: (pageSige: PaginationState["pageSize"]) => void;
  setPagination: (pagination: PaginationState) => void;
  setSorting: (sorting: SortingState) => void;
};

export type DataTableStoreType = DataTableStoreState & DataTableStoreActions;

export type CreateDataTableStoreProps = {
  id: string;
  initialState?: Partial<DataTableStoreState>;
};

const defaultState: DataTableStoreState = {
  columnOrder: [],
  columnSizing: {},
  columnVisibility: {},
  globalFilter: "",
  pageIndex: 0,
  pageSize: 10,
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
        setGlobalFilter: (globalFilter) =>
          set({
            globalFilter: globalFilter,
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
