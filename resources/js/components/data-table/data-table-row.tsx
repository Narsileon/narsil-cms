import { TableRow } from "@narsil-ui/components/table";
import { cn } from "@narsil-ui/lib/utils";
import { type ComponentProps } from "react";

type DataTableRowProps = ComponentProps<typeof TableRow> & {
  selected?: boolean;
};

function DataTableRow({ className, selected = false, ...props }: DataTableRowProps) {
  return (
    <TableRow
      data-slot="data-table-row"
      data-selected={selected}
      className={cn("data-[selected=true]:bg-accent", className)}
      {...props}
    />
  );
}

export default DataTableRow;
