import { cn } from "@narsil-cms/lib/utils";
import { MoreHorizontalIcon } from "lucide-react";
import { VisuallyHidden } from "@narsil-cms/components/ui/visually-hidden";

type PaginationEllipsisProps = React.ComponentProps<"span"> & {
  label?: string;
};

function PaginationEllipsis({
  className,
  label,
  ...props
}: PaginationEllipsisProps) {
  return (
    <span
      aria-hidden
      data-slot="pagination-ellipsis"
      className={cn("flex size-9 items-center justify-center", className)}
      {...props}
    >
      <MoreHorizontalIcon className="size-4" />
      <VisuallyHidden>{label ?? "More pages"}</VisuallyHidden>
    </span>
  );
}

export default PaginationEllipsis;
