import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/ui/icon";
import { Input } from "@narsil-cms/components/ui/input";
import useDataTable from "./data-table-context";

type DataTableInputProps = React.ComponentProps<typeof Input> & {};

function DataTableInput({ className, ...props }: DataTableInputProps) {
  const { dataTableStore } = useDataTable();

  return (
    <div className={cn("relative", className)}>
      <Icon
        className="absolute top-1/2 left-3 size-4 -translate-y-1/2"
        name="search"
      />
      <Input
        className={cn("pl-9")}
        value={dataTableStore.search ?? ""}
        onChange={(event) => dataTableStore.setSearch(event.target.value)}
        {...props}
      />
      {dataTableStore.search ? (
        <Icon
          className="absolute top-1/2 right-3 size-4 -translate-y-1/2"
          name="x"
          onClick={() => dataTableStore.setSearch(null)}
        />
      ) : null}
    </div>
  );
}

export default DataTableInput;
