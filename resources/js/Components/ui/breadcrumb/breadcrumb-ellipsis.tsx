import { cn } from "@/Components";
import { MoreHorizontal } from "lucide-react";

export type BreadcrumbEllipsisProps = React.ComponentProps<"span"> & {};

function BreadcrumbEllipsis({ className, ...props }: BreadcrumbEllipsisProps) {
  return (
    <span
      className={cn("flex size-9 items-center justify-center", className)}
      aria-hidden="true"
      data-slot="breadcrumb-ellipsis"
      role="presentation"
      {...props}
    >
      <MoreHorizontal className="size-4" />
      <span className="sr-only">More</span>
    </span>
  );
}

export default BreadcrumbEllipsis;
