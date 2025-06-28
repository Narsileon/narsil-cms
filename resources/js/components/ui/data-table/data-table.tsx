import { Table } from "@/components/ui/table";
import useDataTable from "./data-table-context";
import type { TableProps } from "@/components/ui/table";

export type DataTableProps = TableProps & {};

function DataTable({ ...props }) {
  const { dataTable } = useDataTable();

  const columns = dataTable.getAllColumns();

  return (
    <Table
      data-slot="data-table"
      className="w-fit"
      aria-colcount={columns.length}
      {...props}
    />
  );
}

export default DataTable;
