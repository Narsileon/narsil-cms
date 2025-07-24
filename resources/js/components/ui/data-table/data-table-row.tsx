import { TableRow } from "@narsil-cms/components/ui/table";
import { cn } from "@narsil-cms/lib/utils";

type DataTableRowProps = React.ComponentProps<typeof TableRow> & {};

function DataTableRow({ className, ...props }: DataTableRowProps) {
  return (
    <TableRow
      data-slot="data-table-row"
      className={cn("data-[state=selected]:bg-muted bg-background", className)}
      {...props}
    />
  );
}

export default DataTableRow;
