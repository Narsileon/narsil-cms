import { TableHead } from "@narsil-cms/components/table";
import { cn } from "@narsil-cms/lib/utils";
import type { Model } from "@narsil-cms/types";
import { flexRender, Header } from "@tanstack/react-table";
import { upperFirst } from "lodash";
import { type ComponentProps } from "react";
import DataTableHeadSort from "./data-table-head-sort";

type DataTableHeadProps = ComponentProps<typeof TableHead> & {
  header: Header<Model, unknown>;
};

function DataTableHead({ className, header, ...props }: DataTableHeadProps) {
  return (
    <TableHead
      className={cn(
        "bg-linear-to-r to-background group-hover:to-accent group-data-[selected=true]:to-accent transition-colors",
        className,
      )}
      colSpan={header.colSpan}
      {...props}
    >
      {typeof header.column.columnDef.header === "string" ? (
        <div className="flex items-center justify-start">
          {upperFirst(header.column.columnDef.header)}

          {header.column.getCanSort() ? <DataTableHeadSort header={header} /> : null}
        </div>
      ) : (
        flexRender(header.column.columnDef.header, header.getContext())
      )}
    </TableHead>
  );
}

export default DataTableHead;
