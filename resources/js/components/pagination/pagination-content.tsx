import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function PaginationContent({ className, ...props }: ComponentProps<"ul">) {
  return (
    <ul
      data-slot="pagination-content"
      className={cn("flex flex-row items-center", className)}
      {...props}
    />
  );
}

export default PaginationContent;
