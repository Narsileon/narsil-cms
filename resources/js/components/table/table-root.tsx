import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type TableRootProps = ComponentProps<"table">;

function TableRoot({ className, ...props }: TableRootProps) {
  return (
    <table
      data-slot="table-root"
      className={cn("w-full caption-bottom overflow-x-scroll", className)}
      {...props}
    />
  );
}

export default TableRoot;
