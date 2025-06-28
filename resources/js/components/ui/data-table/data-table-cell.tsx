import { TableCell } from "@/components/ui/table";
import type { TableCellProps } from "@/components/ui/table";

export type DataTableCellProps = TableCellProps & {};

function DataTableCell({ ...props }) {
  return <TableCell data-slot="data-table-cell" {...props} />;
}

export default DataTableCell;
