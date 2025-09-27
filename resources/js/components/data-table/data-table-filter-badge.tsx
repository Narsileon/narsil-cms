import { isEmpty } from "lodash";
import { useEffect, useState, type ComponentProps } from "react";

import { Badge } from "@narsil-cms/blocks";
import { Select } from "@narsil-cms/blocks/inputs";
import { useLabels } from "@narsil-cms/components/labels";
import {
  PopoverContent,
  PopoverPortal,
  PopoverRoot,
  PopoverTrigger,
} from "@narsil-cms/components/popover";
import { getField } from "@narsil-cms/plugins/fields";
import { type Field } from "@narsil-cms/types";

import { type ColumnFilter } from ".";
import useDataTable from "./data-table-context";

type DataTableFilterBadgeProps = ComponentProps<typeof PopoverTrigger> & {
  filter: ColumnFilter;
};

function DataTableFilterBadge({ filter, ...props }: DataTableFilterBadgeProps) {
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

  useEffect(() => {
    if (isEmpty(filter.operator)) {
      dataTableStore.updateFilter(filter.column, {
        operator: meta.operators[0],
      });

      onOpenChange(true);
    }
  }, [filter.operator]);

  const operatorOptions = meta.operators.map((operator) => {
    return {
      label: trans(`operators.${operator}`),
      value: operator,
    };
  });

  return (
    <PopoverRoot open={open} onOpenChange={onOpenChange} modal={true}>
      <PopoverTrigger asChild={true} {...props}>
        <Badge
          className="cursor-pointer"
          onClose={() => dataTableStore.removeFilter(filter.column)}
        >
          {column.columnDef.header as string}
        </Badge>
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

export default DataTableFilterBadge;
