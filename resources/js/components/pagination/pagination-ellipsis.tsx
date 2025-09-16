import { VisuallyHidden } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";
import { type IconName } from "@narsil-cms/plugins/icons";

type PaginationEllipsisProps = React.ComponentProps<"span"> & {
  icon?: IconName;
  label?: string;
};

function PaginationEllipsis({
  className,
  icon = "more-horizontal",
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
      <Icon className="size-4" name={icon} />
      <VisuallyHidden>{label ?? "More pages"}</VisuallyHidden>
    </span>
  );
}

export default PaginationEllipsis;
