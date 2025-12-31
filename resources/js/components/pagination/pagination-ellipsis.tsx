import { VisuallyHidden } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { cn } from "@narsil-cms/lib/utils";
import { type IconName } from "@narsil-cms/repositories/icons";
import { type ComponentProps } from "react";

type PaginationEllipsisProps = ComponentProps<"span"> & {
  icon?: IconName;
  label?: string;
};

function PaginationEllipsis({
  className,
  icon = "more-horizontal",
  ...props
}: PaginationEllipsisProps) {
  const { trans } = useLocalization();

  return (
    <span
      data-slot="pagination-ellipsis"
      className={cn("flex size-9 items-center justify-center", className)}
      aria-hidden
      {...props}
    >
      <Icon className="size-4" name={icon} />
      <VisuallyHidden>{trans("accessibility.more_pages")}</VisuallyHidden>
    </span>
  );
}

export default PaginationEllipsis;
