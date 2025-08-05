import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";

type BreadcrumbPageProps = React.ComponentProps<"span"> & {};

function BreadcrumbPage({ className, ...props }: BreadcrumbPageProps) {
  return (
    <span
      data-slot="breadcrumb-page"
      className={cn("text-foreground font-normal", className)}
      aria-current="page"
      aria-disabled="true"
      role="link"
      {...props}
    />
  );
}

export default BreadcrumbPage;
