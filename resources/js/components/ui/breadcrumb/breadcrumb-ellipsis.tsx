import { cn } from "@/lib/utils";
import { MoreHorizontal } from "lucide-react";

export type BreadcrumbEllipsisProps = React.ComponentProps<"span"> & {};

function BreadcrumbEllipsis({ className, ...props }: BreadcrumbEllipsisProps) {
  return (
    <span
      data-slot="breadcrumb-ellipsis"
      className={cn("flex size-9 items-center justify-center", className)}
      aria-hidden="true"
      role="presentation"
      {...props}
    >
      <MoreHorizontal className="size-4" />
      <span className="sr-only">More</span>
    </span>
  );
}

export default BreadcrumbEllipsis;
