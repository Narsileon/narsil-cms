import { cn } from "@/lib/utils";
import { MoreHorizontalIcon } from "lucide-react";
import { VisuallyHidden } from "@/components/ui/visually-hidden";

export type PaginationEllipsisProps = React.ComponentProps<"span"> & {};

function PaginationEllipsis({ className, ...props }: PaginationEllipsisProps) {
  return (
    <span
      aria-hidden
      data-slot="pagination-ellipsis"
      className={cn("flex size-9 items-center justify-center", className)}
      {...props}
    >
      <MoreHorizontalIcon className="size-4" />
      <VisuallyHidden>More pages</VisuallyHidden>
    </span>
  );
}

export default PaginationEllipsis;
