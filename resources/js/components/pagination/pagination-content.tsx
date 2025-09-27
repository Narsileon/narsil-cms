import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type PaginationContentProps = ComponentProps<"ul"> & {};

function PaginationContent({ className, ...props }: PaginationContentProps) {
  return (
    <ul
      data-slot="pagination-content"
      className={cn("flex flex-row items-center", className)}
      {...props}
    />
  );
}

export default PaginationContent;
