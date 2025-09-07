import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { TableRow } from "@narsil-cms/components/table";

type DataTableRowProps = React.ComponentProps<typeof TableRow> & {
  selected?: boolean;
};

function DataTableRow({
  className,
  selected = false,
  ...props
}: DataTableRowProps) {
  return (
    <TableRow
      data-slot="data-table-row"
      data-selected={selected}
      className={cn(
        "group data-[selected=true]:bg-accent bg-background",
        className,
      )}
      {...props}
    />
  );
}

export default DataTableRow;
