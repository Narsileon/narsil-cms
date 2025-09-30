import { isEmpty } from "lodash";
import { useEffect, useState, type ComponentProps } from "react";

import { Badge } from "@narsil-cms/blocks";
import { Select } from "@narsil-cms/blocks/fields";
import { useLabels } from "@narsil-cms/components/labels";
import {
  PopoverContent,
  PopoverPortal,
  PopoverRoot,
  PopoverTrigger,
} from "@narsil-cms/components/popover";
import { getField } from "@narsil-cms/plugins/fields";
import type { Field } from "@narsil-cms/types";

import { type ColumnFilter } from ".";
import useDataTable from "./data-table-context";

type DataTableFilterItemProps = ComponentProps<typeof PopoverTrigger> & {
  filter: ColumnFilter;
};

function DataTableFilterItem({ filter, ...props }: DataTableFilterItemProps) {
  const { dataTable, dataTableStore } = useDataTable();
  const { trans } = useLabels();

  const [open, onOpenChange] = useState(false);

  const column = dataTable.getColumn(filter.column);

  if (!column) {
    return null;
  }

  const meta = column.columnDef.meta as {
    field: Field;
    operators: string[];
  };

  const operatorOptions = meta.operators.map((operator) => {
    return {
      label: trans(`operators.${operator}`),
      value: operator,
    };
  });

  useEffect(() => {
    if (isEmpty(filter.operator)) {
      dataTableStore.updateFilter(filter.column, {
        operator: meta.operators[0],
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
            options={operatorOptions}
            value={filter.operator}
            onValueChange={(value) => {
              dataTableStore.updateFilter(filter.column, { operator: value });
            }}
          />
          {getField(meta.field.type, {
            element: meta.field,
            id: filter.column,
            value: filter.value,
            setValue: (value) =>
              dataTableStore.updateFilter(filter.column, { value: value }),
          })}
        </PopoverContent>
      </PopoverPortal>
    </PopoverRoot>
  );
}

export default DataTableFilterItem;
