import { createPortal } from "react-dom";
import { FormInputRenderer } from "@narsil-cms/components/ui/form";
import { get, set } from "lodash";
import { SortableTableRow } from "@narsil-cms/components/ui/sortable";
import { useState } from "react";
import {
  closestCenter,
  DragOverlay,
  DndContext,
  KeyboardSensor,
  MouseSensor,
  TouchSensor,
  useSensor,
  useSensors,
} from "@dnd-kit/core";
import {
  arrayMove,
  SortableContext,
  verticalListSortingStrategy,
} from "@dnd-kit/sortable";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@narsil-cms/components/ui/table";
import type { AnonymousItem } from ".";
import type { Field } from "@narsil-cms/types/forms";
import type {
  DragCancelEvent,
  DragEndEvent,
  DragStartEvent,
} from "@dnd-kit/core";

type SortableTableProps = {
  columns: Field[];
  items: AnonymousItem[];
  placeholder?: string;
  setItems: (items: AnonymousItem[]) => void;
};

function SortableTable({
  columns,
  items,
  placeholder,
  setItems,
}: SortableTableProps) {
  const [active, setActive] = useState<AnonymousItem | null>(null);

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

    if (over) {
      const activeIndex = items.findIndex((x) => x.id === active.id);
      const overIndex = items.findIndex((x) => x.id === over.id);

      if (activeIndex !== overIndex) {
        setItems(arrayMove(items, activeIndex, overIndex));
      }
    }
  }

  function onDragStart({ active }: DragStartEvent) {
    if (!active) {
      return;
    }

    const item = items.find((x) => x.id === active.id) as AnonymousItem;

    setActive(item);
  }

  return (
    <DndContext
      collisionDetection={closestCenter}
      sensors={sensors}
      onDragCancel={onDragCancel}
      onDragEnd={onDragEnd}
      onDragStart={onDragStart}
    >
      <SortableContext items={items} strategy={verticalListSortingStrategy}>
        <div className="overflow-hidden rounded-md border">
          <Table className="w-full table-fixed">
            <TableHeader>
              <TableRow>
                <TableHead className="w-9" />
                {columns.map((column, index) => {
                  return (
                    <TableHead className="px-3" key={index}>
                      {column.name}
                    </TableHead>
                  );
                })}
                <TableHead className="w-9" />
              </TableRow>
            </TableHeader>
            <TableBody>
              {items.map((item) => {
                return (
                  <SortableTableRow
                    className="h-11"
                    id={item.id}
                    onRemove={() => {
                      setItems(items.filter((x) => x !== item));
                    }}
                    key={item.id}
                  >
                    {columns.map((column, index) => {
                      return (
                        <TableCell className="px-0.5 py-0" key={index}>
                          <FormInputRenderer
                            value={
                              get(item, column.handle) ?? column.settings.value
                            }
                            element={column}
                            setValue={(value) => {
                              setItems(
                                items.map((x) =>
                                  x.id === item.id
                                    ? set({ ...x }, column.handle, value)
                                    : x,
                                ),
                              );
                            }}
                          />
                        </TableCell>
                      );
                    })}
                  </SortableTableRow>
                );
              })}
              <SortableTableRow
                id={"placeholder"}
                colSpan={columns.length}
                disabled={true}
                placeholder={true}
                onClick={() => {
                  setItems([...items, { id: crypto.randomUUID() }]);
                }}
              >
                {placeholder}
              </SortableTableRow>
            </TableBody>
            {createPortal(
              <DragOverlay>
                {active ? (
                  <Table>
                    <SortableTableRow id={active.id} className="h-11">
                      {columns.map((column, index) => {
                        return <TableCell key={index} />;
                      })}
                    </SortableTableRow>
                  </Table>
                ) : null}
              </DragOverlay>,
              document.body,
            )}
          </Table>
        </div>
      </SortableContext>
    </DndContext>
  );
}

export default SortableTable;
