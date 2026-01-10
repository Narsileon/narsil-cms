import { Badge } from "@narsil-cms/blocks/badge";
import { Select } from "@narsil-cms/blocks/fields/select";
import {
  PopoverContent,
  PopoverPortal,
  PopoverRoot,
  PopoverTrigger,
} from "@narsil-cms/components/popover";
import { getField } from "@narsil-cms/repositories/fields";
import type { Field, SelectOption } from "@narsil-cms/types";
import { isEmpty } from "lodash-es";
import { useEffect, useState, type ComponentProps } from "react";
import { type ColumnFilter } from ".";
import useDataTable from "./data-table-context";

type DataTableFilterItemProps = ComponentProps<typeof PopoverTrigger> & {
  filter: ColumnFilter;
};

function DataTableFilterItem({ filter, ...props }: DataTableFilterItemProps) {
  const { dataTable, dataTableStore } = useDataTable();

  const [open, onOpenChange] = useState(false);

  const column = dataTable.getColumn(filter.column);

  if (!column) {
    return null;
  }

  const meta = column.columnDef.meta as {
    field: Field;
    operators: SelectOption[];
  };

  useEffect(() => {
    if (isEmpty(filter.operator)) {
      dataTableStore.updateFilter(filter.column, {
        operator: meta.operators[0].value as string,
      });

      onOpenChange(true);
    }
  }, [filter.operator]);

  return (
    <PopoverRoot open={open} onOpenChange={onOpenChange} modal={true}>
      <PopoverTrigger asChild={true} {...props}>
        <li>
          <Badge
            className="cursor-pointer"
            onClose={() => dataTableStore.removeFilter(filter.column)}
          >
            {column.columnDef.header as string}
          </Badge>
        </li>
      </PopoverTrigger>
      <PopoverPortal>
        <PopoverContent className="flex flex-col gap-4">
          <Select
            iconProps={{
              icon: "filter",
            }}
            triggerProps={{
              className: "w-full text-left",
            }}
            options={meta.operators}
            value={filter.operator}
            onValueChange={(value) => {
              dataTableStore.updateFilter(filter.column, { operator: value });
            }}
          />
          {getField(meta.field.type, {
            id: filter.column,
            field: meta.field,
            value: filter.value,
            setValue: (value) => dataTableStore.updateFilter(filter.column, { value: value }),
          })}
        </PopoverContent>
      </PopoverPortal>
    </PopoverRoot>
  );
}

export default DataTableFilterItem;
