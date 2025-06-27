import { TableHead } from "@/components/ui/table";
import type { TableHeadProps } from "@/components/ui/table";

export type DataTableHeadProps = TableHeadProps & {};

function DataHeadTable({ ...props }) {
  return <TableHead data-slot="data-table-head" {...props} />;
}

export default DataHeadTable;
