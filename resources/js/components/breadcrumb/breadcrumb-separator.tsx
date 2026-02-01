import { cn } from "@narsil-cms/lib/utils";
import { ChevronRightIcon } from "lucide-react";
import { type ComponentProps } from "react";

function BreadcrumbSeparator({ children, className, ...props }: ComponentProps<"li">) {
  return (
    <li
      data-slot="breadcrumb-separator"
      role="presentation"
      className={cn("[&>svg]:size-3.5", className)}
      aria-hidden="true"
      {...props}
    >
      {children ?? <ChevronRightIcon name="chevron-right" />}
    </li>
  );
}

export default BreadcrumbSeparator;
