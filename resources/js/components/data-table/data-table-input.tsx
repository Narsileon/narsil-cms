import { type ComponentProps } from "react";

import { Icon } from "@narsil-cms/components/icon";
import { InputContent, InputRoot } from "@narsil-cms/components/input";
import { useLocalization } from "@narsil-cms/components/localization";
import { cn } from "@narsil-cms/lib/utils";

import useDataTable from "./data-table-context";

type DataTableInputProps = ComponentProps<typeof InputContent> & {};

function DataTableInput({ className, ...props }: DataTableInputProps) {
  const { trans } = useLocalization();

  const { dataTableStore } = useDataTable();

  return (
    <div className={cn("relative", className)}>
      <InputRoot>
        <Icon name="search" />
        <InputContent
          placeholder={trans("placeholders.search")}
          value={dataTableStore.search ?? ""}
          onChange={(event) => dataTableStore.setSearch(event.target.value)}
          {...props}
        />
        {dataTableStore.search ? (
          <Icon name="x" onClick={() => dataTableStore.setSearch(null)} />
        ) : null}
      </InputRoot>
    </div>
  );
}

export default DataTableInput;
