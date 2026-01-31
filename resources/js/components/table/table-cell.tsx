import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function TableCell({ className, ...props }: ComponentProps<"td">) {
  return (
    <td
      data-slot="table-cell"
      className={cn(
        "h-9 bg-inherit px-3 align-middle whitespace-nowrap",
        "*:[[role=checkbox]]:translate-y-0.5",
        className,
      )}
      {...props}
    />
  );
}

export default TableCell;
