import { cn } from "@/lib/utils";
import { MoreHorizontal } from "lucide-react";
import { VisuallyHidden } from "@/components/ui/visually-hidden";

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
      <VisuallyHidden>More</VisuallyHidden>
    </span>
  );
}

export default BreadcrumbEllipsis;
