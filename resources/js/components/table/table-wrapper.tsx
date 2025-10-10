import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type TableWrapperProps = ComponentProps<"div">;

function TableWrapper({ className, ...props }: TableWrapperProps) {
  return (
    <div
      data-slot="table-wrapper"
      className={cn("overflow-x-auto rounded-md border shadow", className)}
      {...props}
    />
  );
}

export default TableWrapper;
