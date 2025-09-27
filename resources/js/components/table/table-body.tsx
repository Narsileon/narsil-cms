import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type TableBodyProps = ComponentProps<"tbody"> & {};

function TableBody({ className, ...props }: TableBodyProps) {
  return (
    <tbody
      data-slot="table-body"
      className={cn("[&_tr:last-child]:border-0", className)}
      {...props}
    />
  );
}

export default TableBody;
