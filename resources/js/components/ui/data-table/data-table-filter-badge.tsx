import * as React from "react";
import { Badge } from "@narsil-cms/components/ui/badge";
import { DropdownMenuTrigger } from "@narsil-cms/components/ui/dropdown-menu";
import { Icon } from "@narsil-cms/components/ui/icon";
import { isEmpty } from "lodash";
import { useEffect } from "react";
import { useLabels } from "@narsil-cms/components/ui/labels";
import useDataTable from "./data-table-context";
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from "@narsil-cms/components/ui/popover";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@narsil-cms/components/ui/select";
import type { ColumnFilter } from ".";

type DataTableFilterBadgeProps = React.ComponentProps<
  typeof DropdownMenuTrigger
> & {
  filter: ColumnFilter;
};

function DataTableFilterBadge({ filter, ...props }: DataTableFilterBadgeProps) {
  const { dataTable, dataTableStore } = useDataTable();
  const { trans } = useLabels();

  const [open, onOpenChange] = React.useState(false);

  const column = dataTable.getColumn(filter.column);

  if (!column) {
    return null;
  }

  const meta = column.columnDef.meta as {
    operators: string[];
  };

  useEffect(() => {
    if (isEmpty(filter.operator)) {
      dataTableStore.updateFilter(filter.column, {
        operator: meta.operators[0],
      });

      onOpenChange(true);
    }
  }, [filter.operator]);

  return (
    <Popover open={open} onOpenChange={onOpenChange} modal={true}>
      <PopoverTrigger asChild={true}>
        <Badge className="cursor-pointer">
          <span>{column.columnDef.header as string}</span>
          <button
            className="hover:text-destructive cursor-pointer"
            type="button"
            onClick={() => dataTableStore.removeFilter(filter.column)}
          >
            <Icon className="size-4" name="x" />
          </button>
        </Badge>
      </PopoverTrigger>
      <PopoverContent>
        <Select
          value={filter.operator}
          onValueChange={(value) => {
            dataTableStore.updateFilter(filter.column, { operator: value });
          }}
        >
          <SelectTrigger className="w-full text-left">
            <SelectValue>
              <Icon name="filter" />
              {trans(`operators.${filter.operator}`)}
            </SelectValue>
          </SelectTrigger>
          <SelectContent>
            {meta.operators.map((operator) => (
              <SelectItem value={operator} key={operator}>
                {trans(`operators.${operator}`)}
              </SelectItem>
            ))}
          </SelectContent>
        </Select>
      </PopoverContent>
    </Popover>
  );
}

export default DataTableFilterBadge;
