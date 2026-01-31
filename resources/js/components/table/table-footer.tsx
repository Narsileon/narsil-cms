import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function TableFooter({ className, ...props }: ComponentProps<"tfoot">) {
  return (
    <tfoot
      data-slot="table-footer"
      className={cn("border-t bg-muted/50 font-medium", "[&>tr]:last:border-b-0", className)}
      {...props}
    />
  );
}

export default TableFooter;
