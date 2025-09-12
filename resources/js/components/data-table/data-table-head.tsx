import { useSortable } from "@dnd-kit/sortable";
import { CSS } from "@dnd-kit/utilities";
import { flexRender, Header } from "@tanstack/react-table";

import { TableHead } from "@narsil-cms/components/table";
import { cn } from "@narsil-cms/lib/utils";

import DataTableHeadMove from "./data-table-head-move";
import DataTableHeadSort from "./data-table-head-sort";

type DataTableHeadProps = React.ComponentProps<typeof TableHead> & {
  header: Header<any, any>;
};

function DataTableHead({ header, style, ...props }: DataTableHeadProps) {
  const isCustom = header.column.id.startsWith("_");
  const isMenu = header.column.id === "_menu";

  const { attributes, isDragging, listeners, transform, setNodeRef } =
    useSortable({
      id: header.column.id,
      disabled: header.column.id.startsWith("_"),
    });

  return (
    <TableHead
      ref={setNodeRef}
      data-slot="data-table-head"
      className={cn(
        "bg-linear-to-r to-background transition-colors group-hover:to-accent group-data-[selected=true]:to-accent",
        !isCustom && "px-1",
        isDragging && "z-10 opacity-80",
        isMenu ? "sticky right-0 from-transparent to-20%" : "relative",
      )}
      colSpan={header.colSpan}
      style={{
        ...style,
        transform: CSS.Translate.toString(transform),
        transition: "width transform 0.2s ease-in-out",
        width: header.column.getSize(),
      }}
      {...props}
    >
      {typeof header.column.columnDef.header === "string" ? (
        <div className="flex items-center justify-start">
          <DataTableHeadMove attributes={attributes} listeners={listeners}>
            {header.column.columnDef.header}
          </DataTableHeadMove>

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
