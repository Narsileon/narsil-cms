import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/ui/icon";
import { Input } from "@narsil-cms/components/ui/input";
import { useLabels } from "@narsil-cms/components/ui/labels";
import useDataTable from "./data-table-context";

type DataTableInputProps = React.ComponentProps<typeof Input> & {};

function DataTableInput({ className, ...props }: DataTableInputProps) {
  const { trans } = useLabels();

  const { dataTableStore } = useDataTable();

  return (
    <div className={cn("relative", className)}>
      <Icon
        className="absolute top-1/2 left-2 -translate-y-1/2"
        name="search"
      />
      <Input
        className={cn("px-9")}
        placeholder={trans("placeholders.search")}
        value={dataTableStore.search ?? ""}
        onChange={(event) => dataTableStore.setSearch(event.target.value)}
        {...props}
      />
      {dataTableStore.search ? (
        <Icon
          className="absolute top-1/2 right-2 -translate-y-1/2"
          name="x"
          onClick={() => dataTableStore.setSearch(null)}
        />
      ) : null}
    </div>
  );
}

export default DataTableInput;
