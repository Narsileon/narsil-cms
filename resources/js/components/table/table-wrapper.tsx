import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function TableWrapper({ className, ...props }: ComponentProps<"div">) {
  return (
    <div
      data-slot="table-wrapper"
      className={cn("overflow-x-auto rounded-md border shadow", className)}
      {...props}
    />
  );
}

export default TableWrapper;
