import { cn } from "@narsil-cms/lib/utils";
import { MoreHorizontalIcon } from "lucide-react";
import { type ComponentProps } from "react";

type BreadcrumbEllipsisProps = ComponentProps<"span"> & {
  label?: string;
};

function BreadcrumbEllipsis({
  children,
  className,
  label = "More",
  ...props
}: BreadcrumbEllipsisProps) {
  return (
    <span
      data-slot="breadcrumb-ellipsis"
      role="presentation"
      className={cn("flex size-5 items-center justify-center [&>svg]:size-4", className)}
      aria-hidden="true"
      {...props}
    >
      {children ?? <MoreHorizontalIcon />}
      <span className="sr-only">{label}</span>
    </span>
  );
}

export default BreadcrumbEllipsis;
