import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function BreadcrumbPage({ className, ...props }: ComponentProps<"span">) {
  return (
    <span
      data-slot="breadcrumb-page"
      role="link"
      className={cn("font-normal text-foreground", className)}
      aria-current="page"
      aria-disabled="true"
      {...props}
    />
  );
}

export default BreadcrumbPage;
