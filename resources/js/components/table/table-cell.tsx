import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type TableCellProps = ComponentProps<"td">;

function TableCell({ className, ...props }: TableCellProps) {
  return (
    <td
      data-slot="table-cell"
      className={cn(
        "h-9 bg-inherit px-3 align-middle whitespace-nowrap",
        "[&>[role=checkbox]]:translate-y-0.5",
        className,
      )}
      {...props}
    />
  );
}

export default TableCell;
