import * as React from "react";
import { TableRoot } from "@narsil-cms/components/table";
import useDataTable from "./data-table-context";

type DataTableRootProps = React.ComponentProps<typeof TableRoot> & {};

function DataTableRoot({ ...props }: DataTableRootProps) {
  const { dataTable } = useDataTable();

  const columns = dataTable.getAllColumns();

  return (
    <TableRoot
      data-slot="data-table-root"
      aria-colcount={columns.length}
      {...props}
    />
  );
}

export default DataTableRoot;
