import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";

type TableHeadProps = React.ComponentProps<"th"> & {};

function TableHead({ className, ...props }: TableHeadProps) {
  return (
    <th
      data-slot="table-head"
      className={cn(
        "text-foreground h-9 px-3 text-left align-middle font-medium whitespace-nowrap",
        "[&>[role=checkbox]]:translate-y-[2px]",
        className,
      )}
      {...props}
    />
  );
}

export default TableHead;
