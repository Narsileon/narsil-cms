import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function TableHead({ className, ...props }: ComponentProps<"th">) {
  return (
    <th
      data-slot="table-head"
      className={cn(
        "h-9 bg-inherit px-3 text-left align-middle font-medium whitespace-nowrap",
        "*:[[role=checkbox]]:translate-y-0.5",
        className,
      )}
      {...props}
    />
  );
}

export default TableHead;
