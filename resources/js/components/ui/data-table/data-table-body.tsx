import { TableBody } from "@/components/ui/table";
import type { TableBodyProps } from "@/components/ui/table";

export type DataTableBodyProps = TableBodyProps & {};

function DataTableBody({ ...props }) {
  return <TableBody data-slot="data-table-body" {...props} />;
}

export default DataTableBody;
