import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function BreadcrumbItem({ className, ...props }: ComponentProps<"li">) {
  return (
    <li
      data-slot="breadcrumb-item"
      className={cn("inline-flex items-center gap-1", className)}
      {...props}
    />
  );
}

export default BreadcrumbItem;
