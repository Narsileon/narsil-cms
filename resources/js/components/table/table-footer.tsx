import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type TableFooterProps = ComponentProps<"tfoot"> & {};

function TableFooter({ className, ...props }: TableFooterProps) {
  return (
    <tfoot
      data-slot="table-footer"
      className={cn(
        "bg-muted/50 border-t font-medium",
        "[&>tr]:last:border-b-0",
        className,
      )}
      {...props}
    />
  );
}

export default TableFooter;
