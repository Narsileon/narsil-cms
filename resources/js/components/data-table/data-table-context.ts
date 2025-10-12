import { type DataTableStoreType } from "@narsil-cms/stores/data-table-store";
import type { Model } from "@narsil-cms/types";
import { Table } from "@tanstack/react-table";
import { createContext, useContext } from "react";

export type DataTableContextProps = {
  dataTable: Table<Model>;
  dataTableStore: DataTableStoreType;
};

export const DataTableContext = createContext<DataTableContextProps | null>(null);

function useDataTable() {
  const context = useContext(DataTableContext);

  if (!context) {
    throw new Error("useDataTable must be used within a DataTableProvider.");
  }

  return context;
}

export default useDataTable;
