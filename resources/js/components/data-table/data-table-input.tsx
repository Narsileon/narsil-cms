import { cn } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/icon";
import { Input } from "@narsil-cms/components/input";
import { useLabels } from "@narsil-cms/components/labels";
import useDataTable from "./data-table-context";

type DataTableInputProps = React.ComponentProps<typeof Input> & {};

function DataTableInput({ className, ...props }: DataTableInputProps) {
  const { trans } = useLabels();

  const { dataTableStore } = useDataTable();

  return (
    <div className={cn("relative", className)}>
      <Input
        placeholder={trans("placeholders.search")}
        value={dataTableStore.search ?? ""}
        onChange={(event) => dataTableStore.setSearch(event.target.value)}
        leftChildren={<Icon name="search" />}
        rightChildren={
          dataTableStore.search ? (
            <Icon name="x" onClick={() => dataTableStore.setSearch(null)} />
          ) : null
        }
        {...props}
      />
    </div>
  );
}

export default DataTableInput;
