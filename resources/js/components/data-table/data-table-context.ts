import * as React from "react";
import { Table } from "@tanstack/react-table";
import type { DataTableStoreType } from "@narsil-cms/stores/data-table-store";

export type DataTableContextProps = {
  dataTable: Table<any>;
  dataTableStore: DataTableStoreType;
};

export const DataTableContext =
  React.createContext<DataTableContextProps | null>(null);

function useDataTable() {
  const context = React.useContext(DataTableContext);

  if (!context) {
    throw new Error("useDataTable must be used within a DataTableProvider.");
  }

  return context;
}

export default useDataTable;
