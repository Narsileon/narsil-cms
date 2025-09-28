import {
  closestCenter,
  DragOverlay,
  DndContext,
  KeyboardSensor,
  MouseSensor,
  TouchSensor,
  useSensor,
  useSensors,
  type DragCancelEvent,
  type DragEndEvent,
  type DragStartEvent,
  type UniqueIdentifier,
} from "@dnd-kit/core";
import {
  arrayMove,
  SortableContext,
  useSortable,
  verticalListSortingStrategy,
} from "@dnd-kit/sortable";
import { CSS } from "@dnd-kit/utilities";
import { get, set, upperFirst } from "lodash";
import { useState, type ComponentProps } from "react";
import { createPortal } from "react-dom";

import { Button } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";
import { SortableHandle } from "@narsil-cms/components/sortable";
import {
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRoot,
  TableRow,
} from "@narsil-cms/components/table";
import { cn } from "@narsil-cms/lib/utils";
import { getField } from "@narsil-cms/plugins/fields";
import { type Field } from "@narsil-cms/types";

type TableItem = {
  id: UniqueIdentifier;
};

type TableProps = {
  columns: Field[];
  placeholder?: string;
  rows: TableItem[];
  setRows: (rows: TableItem[]) => void;
};

function Table({ columns, placeholder, rows, setRows }: TableProps) {
  const [active, setActive] = useState<TableItem | null>(null);

  const sensors = useSensors(
    useSensor(MouseSensor, {}),
    useSensor(TouchSensor, {}),
    useSensor(KeyboardSensor, {}),
  );

  function onDragCancel({}: DragCancelEvent) {
    setActive(null);
  }

  function onDragEnd({ active, over }: DragEndEvent) {
    setActive(null);

    if (!over) {
      return;
    }

    const activeIndex = rows.findIndex((row) => row.id === active.id);
    const overIndex = rows.findIndex((row) => row.id === over.id);

    if (activeIndex === overIndex) {
      return;
    }

    setRows(arrayMove(rows, activeIndex, overIndex));
  }

  function onDragStart({ active }: DragStartEvent) {
    if (!active) {
      return;
    }

    const activeRow = rows.find((row) => row.id === active.id);

    if (!activeRow) {
      return;
    }

    setActive(activeRow);
  }

  function onAdd(id: UniqueIdentifier) {
    setRows([...rows, { id: id }]);
  }

  function onRemove(id: UniqueIdentifier) {
    setRows(rows.filter((row) => row.id !== id));
  }

  function onUpdate(id: UniqueIdentifier, key: string, value: unknown) {
    setRows(
      rows.map((row) => (row.id === id ? set({ ...row }, key, value) : row)),
    );
  }

  return (
    <DndContext
      sensors={sensors}
      collisionDetection={closestCenter}
      onDragCancel={onDragCancel}
      onDragEnd={onDragEnd}
      onDragStart={onDragStart}
    >
      <SortableContext
        items={rows.map((row) => row.id)}
        strategy={verticalListSortingStrategy}
      >
        <div className="overflow-hidden rounded-md border">
          <TableRoot className="w-full table-fixed">
            <TableHeader>
              <TableRow>
                <TableHead className="w-9" />
                {columns.map((column, index) => {
                  return (
                    <TableHead className="px-3" key={index}>
                      {upperFirst(column.name)}
                    </TableHead>
                  );
                })}
                <TableHead className="w-9" />
              </TableRow>
            </TableHeader>
            <TableBody>
              {rows.map((row) => {
                return (
                  <SortableItem
                    className="h-11"
                    id={row.id}
                    onRemove={onRemove}
                    key={row.id}
                  >
                    {columns.map((column, index) => {
                      const value = get(
                        row,
                        column.handle,
                        column.settings.value,
                      );

                      return (
                        <TableCell className="px-0.5 py-0" key={index}>
                          {getField(column.type, {
                            id: column.handle,
                            element: column,
                            value: value,
                            setValue: (value) => {
                              onUpdate(row.id, column.handle, value);
                            },
                          })}
                        </TableCell>
                      );
                    })}
                  </SortableItem>
                );
              })}
              <SortableItem
                id={"placeholder"}
                colSpan={columns.length}
                disabled={true}
                placeholder={true}
                onClick={() => {
                  onAdd(crypto.randomUUID());
                }}
              >
                {placeholder}
              </SortableItem>
            </TableBody>
            {createPortal(
              <DragOverlay>
                {active ? (
                  <TableRoot>
                    <SortableItem id={active.id} className="h-11">
                      {columns.map((column, index) => {
                        return <TableCell key={index} />;
                      })}
                    </SortableItem>
                  </TableRoot>
                ) : null}
              </DragOverlay>,
              document.body,
            )}
          </TableRoot>
        </div>
      </SortableContext>
    </DndContext>
  );
}

export default Table;

type SortableItemProps = Omit<ComponentProps<typeof TableRow>, "id"> & {
  colSpan?: number;
  disabled?: boolean;
  id: UniqueIdentifier;
  placeholder?: boolean;
  onRemove?: (id: UniqueIdentifier) => void;
};

function SortableItem({
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
}: SortableItemProps) {
  const { trans } = useLabels();

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
            tooltip={trans("ui.move", "Move")}
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
            icon="trash"
            size="icon"
            tooltip={trans("ui.remove", "Remove")}
            variant="ghost"
            onClick={() => onRemove(id)}
          />
        ) : null}
      </TableCell>
    </TableRow>
  );
}
