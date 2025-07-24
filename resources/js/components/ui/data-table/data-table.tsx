import { Table } from "@narsil-cms/components/ui/table";
import useDataTable from "./data-table-context";

type DataTableProps = React.ComponentProps<typeof Table> & {};

function DataTable({ ...props }: DataTableProps) {
  const { dataTable } = useDataTable();

  const columns = dataTable.getAllColumns();

  return (
    <Table data-slot="data-table" aria-colcount={columns.length} {...props} />
  );
}

export default DataTable;
