import { createContext, useContext } from "react";
import { DataTableStoreType } from "@/stores/data-table-store";
import { Table } from "@tanstack/react-table";

export type DataTableContextProps = {
  table: Table<any>;
  tableStore: DataTableStoreType;
};

export const DataTableContext = createContext<DataTableContextProps | null>(
  null,
);

function useDataTable() {
  const context = useContext(DataTableContext);

  if (!context) {
    throw new Error("useDataTable must be used within a DataTableProvider.");
  }

  return context;
}

export default useDataTable;
