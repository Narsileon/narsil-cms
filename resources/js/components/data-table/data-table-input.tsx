import { Icon } from "@narsil-cms/components/icon";
import { InputContent, InputRoot } from "@narsil-cms/components/input";
import { useLabels } from "@narsil-cms/components/labels";
import { cn } from "@narsil-cms/lib/utils";

import useDataTable from "./data-table-context";

type DataTableInputProps = React.ComponentProps<typeof InputContent> & {};

function DataTableInput({ className, ...props }: DataTableInputProps) {
  const { trans } = useLabels();

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
