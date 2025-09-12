import { Button } from "@narsil-cms/components/button";
import useDataTable from "./data-table-context";
import {
  SelectContent,
  SelectItem,
  SelectRoot,
  SelectTrigger,
  SelectValue,
} from "@narsil-cms/components/select";

type DataTableSizeProps = React.ComponentProps<typeof Button> & {
  options?: string[];
};

function DataTableSize({
  options = ["10", "25", "50", "100"],
}: DataTableSizeProps) {
  const { dataTableStore } = useDataTable();

  return (
    <SelectRoot
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
    </SelectRoot>
  );
}

export default DataTableSize;
