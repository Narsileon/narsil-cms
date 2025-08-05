import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";

type TableCellProps = React.ComponentProps<"td"> & {};

function TableCell({ className, ...props }: TableCellProps) {
  return (
    <td
      data-slot="table-cell"
      className={cn(
        "h-9 px-2 align-middle whitespace-nowrap",
        "[&>[role=checkbox]]:translate-y-[2px]",
        className,
      )}
      {...props}
    />
  );
}

export default TableCell;
