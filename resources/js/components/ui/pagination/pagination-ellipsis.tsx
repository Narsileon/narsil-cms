import { cn } from "@/components";
import { MoreHorizontalIcon } from "lucide-react";

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
      <span className="sr-only">More pages</span>
    </span>
  );
}

export default PaginationEllipsis;
