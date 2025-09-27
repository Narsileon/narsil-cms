import { type ComponentProps } from "react";

import { TableRow } from "@narsil-cms/components/table";
import { cn } from "@narsil-cms/lib/utils";

type DataTableRowProps = ComponentProps<typeof TableRow> & {
  selected?: boolean;
};

function DataTableRow({
  className,
  selected = false,
  ...props
}: DataTableRowProps) {
  return (
    <TableRow
      data-slot="data-table-row"
      data-selected={selected}
      className={cn(
        "group bg-background data-[selected=true]:bg-accent",
        className,
      )}
      {...props}
    />
  );
}

export default DataTableRow;
