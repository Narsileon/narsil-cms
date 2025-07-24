import { CSS } from "@dnd-kit/utilities";
import { TableCell } from "@narsil-cms/components/ui/table";
import { useSortable } from "@dnd-kit/sortable";
import type { Cell } from "@tanstack/react-table";

type DataTableCellProps = React.ComponentProps<typeof TableCell> & {
  cell: Cell<any, any>;
};

function DataTableCell({ cell, ...props }: DataTableCellProps) {
  const { isDragging, transform, setNodeRef } = useSortable({
    id: cell.column.id,
    disabled: cell.column.id.startsWith("_"),
  });

  const style: React.CSSProperties = {
    opacity: isDragging ? 0.8 : 1,
    position: cell.column.id === "_menu" ? "sticky" : "relative",
    right: 0,
    transform: CSS.Translate.toString(transform),
    transition: "width transform 0.2s ease-in-out",
    width: cell.column.getSize(),
    zIndex: isDragging ? 1 : 0,
  };

  return (
    <TableCell
      ref={setNodeRef}
      data-slot="data-table-cell"
      className="relative bg-inherit"
      style={style}
      {...props}
    />
  );
}

export default DataTableCell;
