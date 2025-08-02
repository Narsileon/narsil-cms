import { Button } from "@narsil-cms/components/ui/button";
import { cn } from "@narsil-cms/lib/utils";
import { CSS } from "@dnd-kit/utilities";
import { TableCell, TableRow } from "@narsil-cms/components/ui/table";
import { PlusIcon, TrashIcon } from "lucide-react";
import { UniqueIdentifier } from "@dnd-kit/core";
import SortableHandle from "./sortable-handle";
import {
  AnimateLayoutChanges,
  defaultAnimateLayoutChanges,
  useSortable,
} from "@dnd-kit/sortable";

type SortableTableRowProps = Omit<
  React.ComponentProps<typeof TableRow>,
  "id"
> & {
  colSpan?: number;
  disabled?: boolean;
  id: UniqueIdentifier;
  placeholder?: boolean;
  onRemove?: () => void;
};

const animateLayoutChanges: AnimateLayoutChanges = (args) =>
  defaultAnimateLayoutChanges({ ...args, wasDragging: true });

function SortableTableRow({
  children,
  className,
  colSpan = 3,
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
    animateLayoutChanges: animateLayoutChanges,
  });

  return (
    <TableRow
      ref={disabled ? undefined : setNodeRef}
      className={cn(
        "h-9",
        isDragging && "opacity-50",
        placeholder &&
          "border-dashed bg-transparent opacity-50 hover:opacity-100",
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
      {placeholder ? (
        <TableCell colSpan={colSpan}>
          <div className="flex items-center justify-center gap-1">
            <PlusIcon className="size-5" />
            <span>{children}</span>
          </div>
        </TableCell>
      ) : (
        <>
          <TableCell className="size-8 py-0 pr-0.5 pl-1">
            <SortableHandle
              ref={setActivatorNodeRef}
              className="rounded-md bg-transparent"
              {...attributes}
              {...listeners}
            />
          </TableCell>
          {children}
          <TableCell className="size-9 py-0 pr-1 pl-0.5">
            {onRemove ? (
              <Button
                className="size-7"
                size="icon"
                type="button"
                variant="ghost"
                onClick={onRemove}
              >
                <TrashIcon className="size-5" />
              </Button>
            ) : null}
          </TableCell>
        </>
      )}
    </TableRow>
  );
}

export default SortableTableRow;
