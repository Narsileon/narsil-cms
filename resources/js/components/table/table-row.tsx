import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type TableRowProps = ComponentProps<"tr">;

function TableRow({ className, ...props }: TableRowProps) {
  return (
    <tr
      data-slot="table-row"
      className={cn("border-b transition-colors", "hover:bg-accent", className)}
      {...props}
    />
  );
}

export default TableRow;
