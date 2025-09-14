import { Icon } from "@narsil-cms/components/icon";
import { VisuallyHiddenRoot } from "@narsil-cms/components/visually-hidden";
import { cn } from "@narsil-cms/lib/utils";

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
      data-slot="pagination-ellipsis"
      className={cn("flex size-9 items-center justify-center", className)}
      aria-hidden
      {...props}
    >
      <Icon className="size-4" name="more-horizontal" />
      <VisuallyHiddenRoot>{label ?? "More pages"}</VisuallyHiddenRoot>
    </span>
  );
}

export default PaginationEllipsis;
