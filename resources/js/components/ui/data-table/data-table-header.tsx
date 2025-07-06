import { TableHeader } from "@/components/ui/table";
import type { TableHeaderProps } from "@/components/ui/table";

export type DataTableHeaderProps = TableHeaderProps & {};

function DataTableHeader({ ...props }: DataTableHeaderProps) {
  return <TableHeader data-slot="data-table-header" {...props} />;
}

export default DataTableHeader;
