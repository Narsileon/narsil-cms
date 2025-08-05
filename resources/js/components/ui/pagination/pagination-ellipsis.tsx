import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/ui/icon";
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
      <Icon className="size-4" name="more-horizontal" />
      <VisuallyHidden>{label ?? "More pages"}</VisuallyHidden>
    </span>
  );
}

export default PaginationEllipsis;
