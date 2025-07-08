import { cn } from "@/lib/utils";
import { MoreHorizontalIcon } from "lucide-react";
import { VisuallyHidden } from "@/components/ui/visually-hidden";
import useTranslationsStore from "@/stores/translations-store";

type PaginationEllipsisProps = React.ComponentProps<"span"> & {};

function PaginationEllipsis({ className, ...props }: PaginationEllipsisProps) {
  const { trans } = useTranslationsStore();

  return (
    <span
      aria-hidden
      data-slot="pagination-ellipsis"
      className={cn("flex size-9 items-center justify-center", className)}
      {...props}
    >
      <MoreHorizontalIcon className="size-4" />
      <VisuallyHidden>
        {trans("accessibility.more_pages", "More pages")}
      </VisuallyHidden>
    </span>
  );
}

export default PaginationEllipsis;
