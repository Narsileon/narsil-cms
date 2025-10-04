import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type TableHeadProps = ComponentProps<"th">;

function TableHead({ className, ...props }: TableHeadProps) {
  return (
    <th
      data-slot="table-head"
      className={cn(
        "text-foreground h-9 whitespace-nowrap px-3 text-left align-middle font-medium",
        "[&>[role=checkbox]]:translate-y-[2px]",
        className,
      )}
      {...props}
    />
  );
}

export default TableHead;
