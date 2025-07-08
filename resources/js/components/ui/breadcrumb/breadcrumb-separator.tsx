import { ChevronRight } from "lucide-react";
import { cn } from "@/lib/utils";

type BreadcrumbSeparatorProps = React.ComponentProps<"li"> & {};

function BreadcrumbSeparator({
  children,
  className,
  ...props
}: BreadcrumbSeparatorProps) {
  return (
    <li
      data-slot="breadcrumb-separator"
      className={cn("[&>svg]:size-3.5", className)}
      aria-hidden="true"
      role="presentation"
      {...props}
    >
      {children ?? <ChevronRight />}
    </li>
  );
}

export default BreadcrumbSeparator;
