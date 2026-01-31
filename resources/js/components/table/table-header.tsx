import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function TableHeader({ className, ...props }: ComponentProps<"thead">) {
  return (
    <thead data-slot="table-header" className={cn("[&_tr]:border-b-2", className)} {...props} />
  );
}
export default TableHeader;
