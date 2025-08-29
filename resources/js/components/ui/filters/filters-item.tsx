import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Input } from "@narsil-cms/components/ui/input";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
} from "@narsil-cms/components/ui/select";
import type { ColumnDef } from "@tanstack/react-table";
import type { Filter } from ".";

type ColumnMeta = {
  operators?: string[];
};

type FiltersItemProps = React.ComponentProps<"div"> & {
  columns: ColumnDef<any, any>[];
  filter: Filter;
  onFilterChange: (key: keyof Filter, value: any) => void;
};

function FiltersItem({
  className,
  columns,
  filter,
  onFilterChange,
  ...props
}: FiltersItemProps) {
  const meta = columns.find((column) => column.id === filter.column)?.meta as
    | ColumnMeta
    | undefined;

  const operators = meta?.operators ?? [];

  return (
    <div className={cn("flex gap-2", className)} {...props}>
      <Select
        value={filter.column}
        onValueChange={(value) => onFilterChange("column", value)}
      >
        <SelectTrigger>{filter.column}</SelectTrigger>
        <SelectContent>
          {columns.map((column) => (
            <SelectItem value={column.id as string} key={column.id}>
              {column.header as string}
            </SelectItem>
          ))}
        </SelectContent>
      </Select>

      <Select
        value={filter.operator}
        onValueChange={(value) => onFilterChange("operator", value)}
      >
        <SelectTrigger>{filter.operator}</SelectTrigger>
        <SelectContent>
          {operators.map((operator) => (
            <SelectItem value={operator} key={operator}>
              {operator}
            </SelectItem>
          ))}
        </SelectContent>
      </Select>

      <Input
        className="flex-1"
        value={filter.value}
        onChange={(event) => onFilterChange("value", event.target.value)}
        placeholder="Value"
      />
    </div>
  );
}

export default FiltersItem;
