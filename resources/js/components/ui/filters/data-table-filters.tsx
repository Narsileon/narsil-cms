import * as React from "react";
import { Button } from "@narsil-cms/components/ui/button";
import { Icon } from "@narsil-cms/components/ui/icon";
import { useDataTable } from "@narsil-cms/components/ui/data-table";
import { useLabels } from "@narsil-cms/components/ui/labels";
import FiltersItem from "./filters-item";
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from "@narsil-cms/components/ui/popover";
import type { ColumnDef } from "@tanstack/react-table";

type DataTableFiltersProps = React.ComponentProps<typeof PopoverTrigger> & {
  columns: ColumnDef<any, any>[];
};

function DataTableFilters({
  className,
  columns,
  ...props
}: DataTableFiltersProps) {
  const { trans } = useLabels();

  const { dataTableStore } = useDataTable();

  function onAddFilter() {
    dataTableStore.setFilters((prev) => [
      ...prev,
      { column: availableColumns[0], operator: operators[0], value: "" },
    ]);
  }

  function onFilterChange(index: number, key: keyof Filter, value: any) {
    dataTableStore.setFilters((prev) => {
      const newFilters = [...prev];
      newFilters[index][key] = value;
      return newFilters;
    });
  }

  return (
    <Popover>
      <PopoverTrigger asChild={true} {...props}>
        <Button variant="outline">
          <Icon name="filter" />
        </Button>
      </PopoverTrigger>
      <PopoverContent>
        <div className="flex flex-col gap-2">
          {dataTableStore.filters.map(({ filter, operator }, index) => (
            <FiltersItem
              columns={columns}
              filter={filter}
              onFilterChange={(key, value) => {
                onFilterChange(index, key, value);
              }}
              key={index}
            />
          ))}

          <div className="mt-2 flex justify-between">
            <Button size="sm" variant="outline" onClick={onAddFilter}>
              <Icon name="plus" />
              <span>{trans("ui.add_filter")}</span>
            </Button>
            <Button size="sm" onClick={() => {}}>
              Apply
            </Button>
          </div>
        </div>
      </PopoverContent>
    </Popover>
  );
}

export default DataTableFilters;
