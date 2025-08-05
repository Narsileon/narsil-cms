import * as React from "react";
import { Button } from "@narsil-cms/components/ui/button";
import { cn } from "@narsil-cms/lib/utils";
import { CSS } from "@dnd-kit/utilities";
import { Icon } from "@narsil-cms/components/ui/icon";
import { SortableHandle } from "@narsil-cms/components/ui/sortable";
import { TableCell, TableRow } from "@narsil-cms/components/ui/table";
import { UniqueIdentifier } from "@dnd-kit/core";
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
      <>
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
              onClick={onRemove}
            >
              <Icon name="trash" />
            </Button>
          ) : null}
        </TableCell>
      </>
    </TableRow>
  );
}

export default SortableTableRow;
