import { cn } from "@/lib/utils";
import { MoreHorizontal } from "lucide-react";
import { VisuallyHidden } from "@/components/ui/visually-hidden";
import useTranslationsStore from "@/stores/translations-store";

type BreadcrumbEllipsisProps = React.ComponentProps<"span"> & {};

function BreadcrumbEllipsis({ className, ...props }: BreadcrumbEllipsisProps) {
  const { trans } = useTranslationsStore();

  return (
    <span
      data-slot="breadcrumb-ellipsis"
      className={cn("flex size-9 items-center justify-center", className)}
      aria-hidden="true"
      role="presentation"
      {...props}
    >
      <MoreHorizontal className="size-4" />
      <VisuallyHidden>
        {trans("accessibility.more_links", "More links")}
      </VisuallyHidden>
    </span>
  );
}

export default BreadcrumbEllipsis;
