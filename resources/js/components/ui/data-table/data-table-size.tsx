import * as React from "react";
import { Button } from "@narsil-cms/components/ui/button";
import useDataTable from "./data-table-context";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@narsil-cms/components/ui/select";

type DataTableSizeProps = React.ComponentProps<typeof Button> & {
  options?: string[];
};

function DataTableSize({
  options = ["10", "25", "50", "100"],
}: DataTableSizeProps) {
  const { dataTableStore } = useDataTable();

  return (
    <Select
      value={dataTableStore.pageSize.toString()}
      onValueChange={(value) => dataTableStore.setPageSize(Number(value))}
    >
      <SelectTrigger>
        <SelectValue />
      </SelectTrigger>
      <SelectContent>
        {options.map((option, index) => (
          <SelectItem value={option} key={index}>
            {option}
          </SelectItem>
        ))}
      </SelectContent>
    </Select>
  );
}

export default DataTableSize;
