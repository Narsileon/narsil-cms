import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";

type TableHeaderProps = React.ComponentProps<"thead"> & {};

function TableHeader({ className, ...props }: TableHeaderProps) {
  return (
    <thead
      data-slot="table-header"
      className={cn("[&_tr]:border-b", className)}
      {...props}
    />
  );
}
export default TableHeader;
