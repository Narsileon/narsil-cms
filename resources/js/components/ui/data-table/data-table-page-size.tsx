import useDataTable from "./data-table-context";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import type { SelectTriggerProps } from "@/components/ui/select";

export type DataTablePageSizeProps = SelectTriggerProps & {
  options: string[];
};

function DataTablePageSize({
  options = ["10", "25", "50", "100"],
  ...props
}: DataTablePageSizeProps) {
  const { tableStore } = useDataTable();

  return (
    <Select
      value={`${tableStore.pageSize}`}
      onValueChange={(value) => tableStore.setPageSize(Number(value))}
    >
      <SelectTrigger {...props}>
        <SelectValue />
      </SelectTrigger>
      <SelectContent side="top">
        {options.map((option, index) => (
          <SelectItem value={option} key={index}>
            {option}
          </SelectItem>
        ))}
      </SelectContent>
    </Select>
  );
}

export default DataTablePageSize;
