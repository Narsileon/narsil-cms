import { type Cell } from "@tanstack/react-table";
import { type ComponentProps } from "react";

import { TableCell } from "@narsil-cms/components/table";
import { cn } from "@narsil-cms/lib/utils";

type DataTableCellProps = ComponentProps<typeof TableCell> & {
  cell: Cell<unknown, unknown>;
};

function DataTableCell({ cell, ...props }: DataTableCellProps) {
  const isMenu = cell.column.id === "_menu";

  return (
    <TableCell
      data-slot="data-table-cell"
      className={cn(
        "bg-linear-to-r to-background group-hover:to-accent group-data-[selected=true]:to-accent transition-colors",
        isMenu
          ? "sticky right-0 min-w-12 max-w-12 from-transparent to-20%"
          : "relative bg-clip-content",
      )}
      {...props}
    />
  );
}

export default DataTableCell;
