import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function TableBody({ className, ...props }: ComponentProps<"tbody">) {
  return (
    <tbody
      data-slot="table-body"
      className={cn("[&_tr:last-child]:border-0", className)}
      {...props}
    />
  );
}

export default TableBody;
