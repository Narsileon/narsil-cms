import { cn } from "@/lib/utils";
import useTranslationsStore from "@/stores/translations-store";
import type { LaravelPagination } from "@/types/global";

export type DataTablePaginationResultProps =
  React.HTMLAttributes<HTMLDivElement> &
    Pick<LaravelPagination, "from" | "to" | "total"> & {};

function DataTablePaginationResult({
  className,
  from,
  to,
  total,
  ...props
}: DataTablePaginationResultProps) {
  const { trans } = useTranslationsStore();

  return (
    <span className={cn("min-w-fit truncate text-sm", className)} {...props}>
      {from && to && total > 0
        ? trans("pagination.results", {
            replacements: {
              from: from,
              to: to,
              total: total,
            },
          })
        : trans("pagination.empty")}
    </span>
  );
}

export default DataTablePaginationResult;
