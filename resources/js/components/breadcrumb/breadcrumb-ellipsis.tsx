import { Icon } from "@narsil-cms/blocks/icon";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function BreadcrumbEllipsis({
  className,
  ellipsisLabel,
  ...props
}: ComponentProps<"span"> & {
  ellipsisLabel?: string;
}) {
  return (
    <span
      data-slot="breadcrumb-ellipsis"
      className={cn("flex size-9 items-center justify-center", className)}
      aria-hidden="true"
      role="presentation"
      {...props}
    >
      <Icon className="size-4" name="more-horizontal" />
      <span className="sr-only">{ellipsisLabel ?? "More links"}</span>
    </span>
  );
}

export default BreadcrumbEllipsis;
