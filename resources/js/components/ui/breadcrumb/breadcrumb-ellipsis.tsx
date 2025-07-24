import { cn } from "@narsil-cms/lib/utils";
import { MoreHorizontal } from "lucide-react";
import { VisuallyHidden } from "@narsil-cms/components/ui/visually-hidden";

type BreadcrumbEllipsisProps = React.ComponentProps<"span"> & {
  ellipsisLabel?: string;
};

function BreadcrumbEllipsis({
  className,
  ellipsisLabel,
  ...props
}: BreadcrumbEllipsisProps) {
  return (
    <span
      data-slot="breadcrumb-ellipsis"
      className={cn("flex size-9 items-center justify-center", className)}
      aria-hidden="true"
      role="presentation"
      {...props}
    >
      <MoreHorizontal className="size-4" />
      <VisuallyHidden>{ellipsisLabel ?? "More links"}</VisuallyHidden>
    </span>
  );
}

export default BreadcrumbEllipsis;
