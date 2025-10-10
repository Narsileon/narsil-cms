import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type BreadcrumbItemProps = ComponentProps<"li">;

function BreadcrumbItem({ className, ...props }: BreadcrumbItemProps) {
  return (
    <li
      data-slot="breadcrumb-item"
      className={cn("inline-flex items-center gap-1.5", className)}
      {...props}
    />
  );
}

export default BreadcrumbItem;
