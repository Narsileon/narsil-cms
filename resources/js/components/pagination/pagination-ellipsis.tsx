import { VisuallyHidden } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";
import { cn } from "@narsil-cms/lib/utils";
import { type IconName } from "@narsil-cms/plugins/icons";

type PaginationEllipsisProps = React.ComponentProps<"span"> & {
  icon?: IconName;
  label?: string;
};

function PaginationEllipsis({
  className,
  icon = "more-horizontal",
  ...props
}: PaginationEllipsisProps) {
  const { trans } = useLabels();

  return (
    <span
      data-slot="pagination-ellipsis"
      className={cn("flex size-9 items-center justify-center", className)}
      aria-hidden
      {...props}
    >
      <Icon className="size-4" name={icon} />
      <VisuallyHidden>
        {trans("accessibility.more_pages", "More pages")}
      </VisuallyHidden>
    </span>
  );
}

export default PaginationEllipsis;
