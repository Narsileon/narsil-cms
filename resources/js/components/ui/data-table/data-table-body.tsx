import { TableBody } from "@/components/ui/table";

type DataTableBodyProps = React.ComponentProps<typeof TableBody> & {};

function DataTableBody({ ...props }: DataTableBodyProps) {
  return <TableBody data-slot="data-table-body" {...props} />;
}

export default DataTableBody;
