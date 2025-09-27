import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type BreadcrumbPageProps = ComponentProps<"span"> & {};

function BreadcrumbPage({ className, ...props }: BreadcrumbPageProps) {
  return (
    <span
      data-slot="breadcrumb-page"
      className={cn("font-normal text-foreground", className)}
      aria-current="page"
      aria-disabled="true"
      role="link"
      {...props}
    />
  );
}

export default BreadcrumbPage;
