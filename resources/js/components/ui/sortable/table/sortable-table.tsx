import * as React from "react";
import { createPortal } from "react-dom";
import { FormInputRenderer } from "@narsil-cms/components/ui/form";
import { get, set } from "lodash";
import SortableTableRow from "./sortable-table-row";
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
import type { Field } from "@narsil-cms/types/forms";
import type {
  DragCancelEvent,
  DragEndEvent,
  DragStartEvent,
  UniqueIdentifier,
} from "@dnd-kit/core";

type SortableTableItem = {
  id: UniqueIdentifier;
};

type SortableTableProps = {
  columns: Field[];
  placeholder?: string;
  rows: SortableTableItem[];
  setRows: (rows: SortableTableItem[]) => void;
};

function SortableTable({
  columns,
  placeholder,
  rows,
  setRows,
}: SortableTableProps) {
  const [active, setActive] = React.useState<SortableTableItem | null>(null);

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

  function onUpdate(id: UniqueIdentifier, key: string, value: any) {
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
              {rows.map((row) => {
                return (
                  <SortableTableRow
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
                          <FormInputRenderer
                            element={column}
                            value={value}
                            setValue={(value) => {
                              onUpdate(row.id, column.handle, value);
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
                  onAdd(crypto.randomUUID());
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
