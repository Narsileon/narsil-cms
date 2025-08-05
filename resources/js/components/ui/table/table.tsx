import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";

type TableProps = React.ComponentProps<"table"> & {};

function Table({ className, ...props }: TableProps) {
  return (
    <table
      data-slot="table"
      className={cn("w-full caption-bottom text-sm", className)}
      {...props}
    />
  );
}

export default Table;
