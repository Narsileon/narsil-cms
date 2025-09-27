import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type BreadcrumbListProps = ComponentProps<"ol"> & {};

function BreadcrumbList({ className, ...props }: BreadcrumbListProps) {
  return (
    <ol
      data-slot="breadcrumb-list"
      className={cn(
        "flex flex-wrap items-center gap-1.5 break-words text-muted-foreground sm:gap-2.5",
        className,
      )}
      {...props}
    />
  );
}

export default BreadcrumbList;
