import { createContext, useContext } from "react";
import { Table } from "@tanstack/react-table";
import type { DataTableStoreType } from "@/stores/data-table-store";

type DataTableContextProps = {
  dataTable: Table<any>;
  dataTableStore: DataTableStoreType;
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
