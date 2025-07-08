import useDataTable from "./data-table-context";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";

type DataTablePageSizeProps = React.ComponentProps<typeof SelectTrigger> & {
  options?: string[];
};

function DataTablePageSize({
  options = ["10", "25", "50", "100"],
  ...props
}: DataTablePageSizeProps) {
  const { dataTableStore } = useDataTable();

  return (
    <Select
      value={`${dataTableStore.pageSize}`}
      onValueChange={(value) => dataTableStore.setPageSize(Number(value))}
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
