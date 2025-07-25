import { CSS } from "@dnd-kit/utilities";
import { flexRender, Header } from "@tanstack/react-table";
import { TableHead } from "@narsil-cms/components/ui/table";
import { useSortable } from "@dnd-kit/sortable";
import DataTableHeadMove from "./data-table-head-move";
import DataTableHeadSort from "./data-table-head-sort";

type DataTableHeadProps = React.ComponentProps<typeof TableHead> & {
  header: Header<any, any>;
};

function DataTableHead({ header, ...props }: DataTableHeadProps) {
  const { attributes, isDragging, listeners, transform, setNodeRef } =
    useSortable({
      id: header.column.id,
      disabled: header.column.id.startsWith("_"),
    });

  const style: React.CSSProperties = {
    opacity: isDragging ? 0.8 : 1,
    position: header.column.id === "_menu" ? "sticky" : "relative",
    right: 0,
    transform: CSS.Translate.toString(transform),
    transition: "width transform 0.2s ease-in-out",
    width: header.column.getSize(),
    zIndex: isDragging ? 1 : 0,
  };

  return (
    <TableHead
      ref={setNodeRef}
      data-slot="data-table-head"
      className="relative min-w-0 px-0"
      colSpan={header.colSpan}
      style={style}
      {...props}
    >
      <div className="flex items-center justify-start">
        <DataTableHeadMove attributes={attributes} listeners={listeners}>
          {flexRender(header.column.columnDef.header, header.getContext())}
        </DataTableHeadMove>
        {header.column.getCanSort() ? (
          <DataTableHeadSort header={header} />
        ) : null}
      </div>
    </TableHead>
  );
}

export default DataTableHead;
