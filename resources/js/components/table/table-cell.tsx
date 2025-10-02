import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type TableCellProps = ComponentProps<"td"> & {};

function TableCell({ className, ...props }: TableCellProps) {
  return (
    <td
      data-slot="table-cell"
      className={cn(
        "h-9 whitespace-nowrap px-3 align-middle",
        "[&>[role=checkbox]]:translate-y-[2px]",
        className,
      )}
      {...props}
    />
  );
}

export default TableCell;
