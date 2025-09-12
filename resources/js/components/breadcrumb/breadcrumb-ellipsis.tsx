import { cn } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/icon";
import { VisuallyHiddenRoot } from "@narsil-cms/components/visually-hidden";

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
      <Icon className="size-4" name="more-horizontal" />
      <VisuallyHiddenRoot>{ellipsisLabel ?? "More links"}</VisuallyHiddenRoot>
    </span>
  );
}

export default BreadcrumbEllipsis;
