import { CSS } from "@dnd-kit/utilities";
import { flexRender, Header } from "@tanstack/react-table";
import { TableHead } from "@/components/ui/table";
import { useSortable } from "@dnd-kit/sortable";
import DataTableHeadMove from "./data-table-head-move";
import DataTableHeadSort from "./data-table-head-sort";
import type { TableHeadProps } from "@/components/ui/table";

export type DataTableHeadProps = TableHeadProps & { header: Header<any, any> };

function DataTableHead({ header, ...props }: DataTableHeadProps) {
  const { attributes, isDragging, listeners, setNodeRef, transform } =
    useSortable({
      id: header.column.id,
    });

  const style: React.CSSProperties = {
    maxWidth: header.column.getSize(),
    opacity: isDragging ? 0.8 : 1,
    position: "relative",
    right: 0,
    transform: CSS.Translate.toString(transform),
    transition: "width transform 0.2s ease-in-out",
    width: header.column.getSize(),
    zIndex: isDragging ? 1 : 0,
  };

  return (
    <TableHead
      ref={setNodeRef}
      className="inline-flex items-center"
      data-slot="data-table-head"
      style={style}
      {...props}
    >
      <DataTableHeadMove attributes={attributes} listeners={listeners}>
        {flexRender(header.column.columnDef.header, header.getContext())}
      </DataTableHeadMove>
      {header.column.getCanSort() ? (
        <DataTableHeadSort header={header} />
      ) : null}
    </TableHead>
  );
}

export default DataTableHead;
