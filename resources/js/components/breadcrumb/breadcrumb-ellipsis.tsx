import { VisuallyHidden } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type BreadcrumbEllipsisProps = ComponentProps<"span"> & {
  ellipsisLabel?: string;
};

function BreadcrumbEllipsis({ className, ellipsisLabel, ...props }: BreadcrumbEllipsisProps) {
  return (
    <span
      data-slot="breadcrumb-ellipsis"
      className={cn("flex size-9 items-center justify-center", className)}
      aria-hidden="true"
      role="presentation"
      {...props}
    >
      <Icon className="size-4" name="more-horizontal" />
      <VisuallyHidden>{ellipsisLabel ?? "More links"}</VisuallyHidden>
    </span>
  );
}

export default BreadcrumbEllipsis;
