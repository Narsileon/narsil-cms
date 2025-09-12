import { Button } from "@narsil-cms/components/button";
import { cn } from "@narsil-cms/lib/utils";
import { CSS } from "@dnd-kit/utilities";
import { Icon } from "@narsil-cms/components/icon";
import { SortableHandle } from "@narsil-cms/components/sortable";
import { TableCell, TableRow } from "@narsil-cms/components/table";
import { useSortable } from "@dnd-kit/sortable";
import { type UniqueIdentifier } from "@dnd-kit/core";

type SortableTableRowProps = Omit<
  React.ComponentProps<typeof TableRow>,
  "id"
> & {
  colSpan?: number;
  disabled?: boolean;
  id: UniqueIdentifier;
  placeholder?: boolean;
  onRemove?: (id: UniqueIdentifier) => void;
};

function SortableTableRow({
  children,
  className,
  colSpan = 1,
  disabled,
  id,
  placeholder,
  style,
  onClick,
  onRemove,
  ...props
}: SortableTableRowProps) {
  const {
    attributes,
    isDragging,
    listeners,
    transform,
    transition,
    setActivatorNodeRef,
    setNodeRef,
  } = useSortable({
    id: id,
  });

  return (
    <TableRow
      ref={disabled ? undefined : setNodeRef}
      className={cn(
        "h-9",
        isDragging && "opacity-50",
        placeholder &&
          "border-dashed bg-transparent opacity-50 will-change-transform hover:opacity-100",
        onClick && "cursor-pointer",
        className,
      )}
      style={{
        ...style,
        transform: CSS.Transform.toString(transform),
        transition: transition,
      }}
      onClick={onClick}
      {...props}
    >
      <TableCell className="px-1 py-0">
        {!placeholder ? (
          <SortableHandle
            ref={setActivatorNodeRef}
            className="rounded-md bg-transparent"
            {...attributes}
            {...listeners}
          />
        ) : null}
      </TableCell>
      {placeholder ? (
        <TableCell colSpan={colSpan}>
          <div className="flex items-center justify-center gap-1">
            <Icon name="plus" />
            <span>{children}</span>
          </div>
        </TableCell>
      ) : (
        children
      )}
      <TableCell className="px-1 py-0">
        {!placeholder && onRemove ? (
          <Button
            className="size-7"
            size="icon"
            variant="ghost"
            onClick={() => onRemove(id)}
          >
            <Icon name="trash" />
          </Button>
        ) : null}
      </TableCell>
    </TableRow>
  );
}

export default SortableTableRow;
