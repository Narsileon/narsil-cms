import { useSortable } from "@dnd-kit/sortable";
import { CSS } from "@dnd-kit/utilities";
import { type Cell } from "@tanstack/react-table";

import { TableCell } from "@narsil-cms/components/table";
import { cn } from "@narsil-cms/lib/utils";

type DataTableCellProps = React.ComponentProps<typeof TableCell> & {
  cell: Cell<unknown, unknown>;
};

function DataTableCell({ cell, style, ...props }: DataTableCellProps) {
  const { isDragging, transform, setNodeRef } = useSortable({
    id: cell.column.id,
    disabled: cell.column.id.startsWith("_"),
  });

  const isMenu = cell.column.id === "_menu";

  return (
    <TableCell
      ref={setNodeRef}
      data-slot="data-table-cell"
      className={cn(
        "bg-linear-to-r to-background transition-colors group-hover:to-accent group-data-[selected=true]:to-accent",
        isDragging && "z-10 opacity-80",
        isMenu
          ? "sticky right-0 from-transparent to-20%"
          : "relative bg-clip-content",
      )}
      style={{
        ...style,
        transform: CSS.Translate.toString(transform),
        transition: "width transform 0.2s ease-in-out",
        width: cell.column.getSize(),
      }}
      {...props}
    />
  );
}

export default DataTableCell;
