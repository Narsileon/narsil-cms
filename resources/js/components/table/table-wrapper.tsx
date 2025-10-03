import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type TableWrapperProps = ComponentProps<"div"> & {};

function TableWrapper({ className, ...props }: TableWrapperProps) {
  return (
    <div
      data-slot="table-wrapper"
      className={cn("overflow-x-auto rounded-md border-2", className)}
      {...props}
    />
  );
}

export default TableWrapper;
