import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type TableHeadProps = ComponentProps<"th"> & {};

function TableHead({ className, ...props }: TableHeadProps) {
  return (
    <th
      data-slot="table-head"
      className={cn(
        "h-9 px-3 text-left align-middle font-medium whitespace-nowrap text-foreground",
        "[&>[role=checkbox]]:translate-y-[2px]",
        className,
      )}
      {...props}
    />
  );
}

export default TableHead;
