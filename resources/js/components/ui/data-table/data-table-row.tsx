import { TableRow } from "@/components/ui/table";

type DataTableRowProps = React.ComponentProps<typeof TableRow> & {};

function DataTableRow({ ...props }: DataTableRowProps) {
  return <TableRow data-slot="data-table-row" {...props} />;
}

export default DataTableRow;
