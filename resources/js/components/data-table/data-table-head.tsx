import { flexRender, Header } from "@tanstack/react-table";
import { type ComponentProps } from "react";

import { TableHead } from "@narsil-cms/components/table";
import { cn } from "@narsil-cms/lib/utils";

import DataTableHeadSort from "./data-table-head-sort";

type DataTableHeadProps = ComponentProps<typeof TableHead> & {
  header: Header<unknown, unknown>;
};

function DataTableHead({ header, ...props }: DataTableHeadProps) {
  const isMenu = header.column.id === "_menu";
  return (
    <TableHead
      data-slot="data-table-head"
      className={cn(
        "bg-linear-to-r to-background transition-colors group-hover:to-accent group-data-[selected=true]:to-accent",
        isMenu ? "sticky right-0 from-transparent to-20%" : "relative",
      )}
      colSpan={header.colSpan}
      {...props}
    >
      {typeof header.column.columnDef.header === "string" ? (
        <div className="flex items-center justify-start">
          {header.column.columnDef.header}

          {header.column.getCanSort() ? (
            <DataTableHeadSort header={header} />
          ) : null}
        </div>
      ) : (
        flexRender(header.column.columnDef.header, header.getContext())
      )}
    </TableHead>
  );
}

export default DataTableHead;
