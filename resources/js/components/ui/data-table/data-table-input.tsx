import { cn } from "@/lib/utils";
import { Input } from "@/components/ui/input";
import { SearchIcon } from "lucide-react";
import useDataTable from "./data-table-context";
import type { InputProps } from "@/components/ui/input";

export type DataTableInputProps = InputProps & {};

function DataTableInput({ className, ...props }: DataTableInputProps) {
  const { dataTableStore } = useDataTable();

  return (
    <div className={cn("relative", className)}>
      <SearchIcon className="absolute top-1/2 left-3 size-4 -translate-y-1/2" />
      <Input
        className={cn("pl-9")}
        value={dataTableStore.globalFilter}
        onChange={(e) => dataTableStore.setGlobalFilter(e.target.value)}
        {...props}
      />
    </div>
  );
}

export default DataTableInput;
