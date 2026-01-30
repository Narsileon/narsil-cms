import { Icon } from "@narsil-cms/blocks/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function PaginationEllipsis({ className, ...props }: ComponentProps<"span">) {
  const { trans } = useLocalization();

  return (
    <span
      data-slot="pagination-ellipsis"
      className={cn("flex size-9 items-center justify-center", className)}
      aria-hidden
      {...props}
    >
      <Icon className="size-4" name="more-horizontal" />
      <span className="sr-only">{trans("accessibility.more_pages")}</span>
    </span>
  );
}

export default PaginationEllipsis;
