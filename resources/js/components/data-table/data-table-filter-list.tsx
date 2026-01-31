import { DataTableFilterItem, useDataTable } from "@narsil-cms/components/data-table";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function DataTableFilterList({ className, ...props }: ComponentProps<"ul">) {
  const { dataTableStore } = useDataTable();

  return dataTableStore.filters.length > 0 ? (
    <ul className={cn("flex items-center gap-2", className)} {...props}>
      {dataTableStore.filters.map((filter, index) => {
        return <DataTableFilterItem filter={filter} key={index} />;
      })}
    </ul>
  ) : null;
}

export default DataTableFilterList;
