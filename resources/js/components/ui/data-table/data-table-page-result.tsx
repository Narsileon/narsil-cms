import { cn } from "@/lib/utils";
import useTranslationsStore from "@/stores/translations-store";
import type { LaravelPaginationMeta } from "@/types/global";

export type DataTablePageResultProps = React.HTMLAttributes<HTMLDivElement> &
  Pick<LaravelPaginationMeta, "from" | "to" | "total"> & {};

function DataTablePageResult({
  className,
  from,
  to,
  total,
  ...props
}: DataTablePageResultProps) {
  const { trans } = useTranslationsStore();

  return (
    <span className={cn("min-w-fit truncate text-sm", className)} {...props}>
      {from && to && total > 0
        ? trans(
            "pagination.results",
            "Showing :from to :to of :total results.",
            {
              replacements: {
                from: from,
                to: to,
                total: total,
              },
            },
          )
        : trans("pagination.empty", "No result.")}
    </span>
  );
}

export default DataTablePageResult;
