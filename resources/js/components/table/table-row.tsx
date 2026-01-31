import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function TableRow({ className, ...props }: ComponentProps<"tr">) {
  return (
    <tr
      data-slot="table-row"
      className={cn("border-b bg-background transition-colors", "hover:bg-accent", className)}
      {...props}
    />
  );
}

export default TableRow;
