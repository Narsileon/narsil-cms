import { TableRow } from "@/components/ui/table";
import type { TableRowProps } from "@/components/ui/table";

export type DataTableRowProps = TableRowProps & {};

function DataTableRow({ ...props }) {
  return <TableRow data-slot="data-table-row" {...props} />;
}

export default DataTableRow;
