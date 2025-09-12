import { cn } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/icon";
import { VisuallyHiddenRoot } from "@narsil-cms/components/visually-hidden";

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
      <VisuallyHiddenRoot>{label ?? "More pages"}</VisuallyHiddenRoot>
    </span>
  );
}

export default PaginationEllipsis;
