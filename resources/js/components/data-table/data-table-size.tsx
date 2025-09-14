import {
  SelectContent,
  SelectItem,
  SelectRoot,
  SelectTrigger,
  SelectValue,
} from "@narsil-cms/components/select";

import useDataTable from "./data-table-context";

type DataTableSizeProps = React.ComponentProps<typeof SelectTrigger> & {
  options?: string[];
};

function DataTableSize({
  options = ["10", "25", "50", "100"],
  ...props
}: DataTableSizeProps) {
  const { dataTableStore } = useDataTable();

  return (
    <SelectRoot
      value={dataTableStore.pageSize.toString()}
      onValueChange={(value) => dataTableStore.setPageSize(Number(value))}
    >
      <SelectTrigger {...props}>
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
