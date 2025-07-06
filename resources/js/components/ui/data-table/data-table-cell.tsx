import { CSS } from "@dnd-kit/utilities";
import { TableCell } from "@/components/ui/table";
import { useSortable } from "@dnd-kit/sortable";
import type { Cell } from "@tanstack/react-table";
import type { TableCellProps } from "@/components/ui/table";

export type DataTableCellProps = TableCellProps & {
  cell: Cell<any, any>;
};

function DataTableCell({ cell, ...props }: DataTableCellProps) {
  const { isDragging, transform, setNodeRef } = useSortable({
    id: cell.column.id,
  });

  const style: React.CSSProperties = {
    opacity: isDragging ? 0.8 : 1,
    transform: CSS.Translate.toString(transform),
    transition: "width transform 0.2s ease-in-out",
    width: cell.column.getSize(),
    zIndex: isDragging ? 1 : 0,
  };

  return (
    <TableCell
      ref={setNodeRef}
      data-slot="data-table-cell"
      className="relative"
      style={style}
      {...props}
    />
  );
}

export default DataTableCell;
