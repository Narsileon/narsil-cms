import { TableRow } from "@/components/ui/table";
import type { TableRowProps } from "@/components/ui/table";

export type DataTableRowProps = TableRowProps & {};

function DataRowTable({ ...props }) {
  return <TableRow data-slot="data-table-row" {...props} />;
}

export default DataRowTable;
