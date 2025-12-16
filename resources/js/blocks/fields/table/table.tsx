import {
  closestCenter,
  DndContext,
  DragOverlay,
  KeyboardSensor,
  MouseSensor,
  TouchSensor,
  useSensor,
  useSensors,
  type DragCancelEvent,
  type DragEndEvent,
  type DragStartEvent,
} from "@dnd-kit/core";
import { arrayMove, SortableContext, verticalListSortingStrategy } from "@dnd-kit/sortable";
import { useFormField } from "@narsil-cms/components/form";
import {
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRoot,
  TableRow,
  TableWrapper,
} from "@narsil-cms/components/table";
import { getField } from "@narsil-cms/plugins/fields";
import type { Field } from "@narsil-cms/types";
import { get, set, upperFirst } from "lodash";
import { useState } from "react";
import { createPortal } from "react-dom";
import { type TableElement } from ".";
import TableItem from "./table-item";

type TableProps = {
  columns: Field[];
  placeholder?: string;
  rows: TableElement[];
  setRows: (rows: TableElement[]) => void;
};

function Table({ columns, placeholder, rows, setRows }: TableProps) {
  const { fieldLanguage } = useFormField();

  const [active, setActive] = useState<TableElement | null>(null);

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

    const activeIndex = rows.findIndex((row) => {
      return row.uuid === active.id;
    });
    const overIndex = rows.findIndex((row) => {
      return row.uuid === over.id;
    });

    if (activeIndex === overIndex) {
      return;
    }

    setRows(arrayMove(rows, activeIndex, overIndex));
  }

  function onDragStart({ active }: DragStartEvent) {
    if (!active) {
      return;
    }

    const activeRow = rows.find((row) => {
      return row.uuid === active.id;
    });

    if (!activeRow) {
      return;
    }

    setActive(activeRow);
  }

  function onAdd(uuid: string) {
    setRows([...rows, { uuid: uuid }]);
  }

  function onMoveUp(uuid: string) {
    const index = rows.findIndex((row) => row.uuid === uuid);

    if (index > 0) {
      setRows(arrayMove(rows, index, index - 1));
    }
  }

  function onMoveDown(uuid: string) {
    const index = rows.findIndex((row) => row.uuid === uuid);

    if (index >= 0 && index < rows.length - 1) {
      setRows(arrayMove(rows, index, index + 1));
    }
  }

  function onRemove(uuid: string) {
    setRows(
      rows.filter((row) => {
        return row.uuid !== uuid;
      }),
    );
  }

  function onUpdate(uuid: string, key: string, value: unknown) {
    setRows(
      rows.map((row) => {
        return row.uuid === uuid ? set({ ...row }, key, value) : row;
      }),
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
      <SortableContext items={rows.map((row) => row.uuid)} strategy={verticalListSortingStrategy}>
        <TableWrapper>
          <TableRoot className="w-full table-fixed">
            <TableHeader>
              <TableRow className="bg-accent">
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
              {rows.map((row, index) => {
                return (
                  <TableItem
                    className="h-11"
                    id={row.uuid}
                    onMoveUp={index > 0 ? () => onMoveUp(row.uuid) : undefined}
                    onMoveDown={index < rows.length - 1 ? () => onMoveDown(row.uuid) : undefined}
                    onRemove={() => onRemove(row.uuid)}
                    key={row.uuid}
                  >
                    {columns.map((column, index) => {
                      const value = get(
                        row,
                        column.translatable ? `${column.handle}.${fieldLanguage}` : column.handle,
                        "value" in column.settings ? column.settings.value : null,
                      );

                      return (
                        <TableCell className="px-0.5 py-0" key={index}>
                          {getField(column.type, {
                            id: column.handle,
                            element: column,
                            value: value,
                            setValue: (value) => {
                              onUpdate(row.uuid, column.handle, value);
                            },
                          })}
                        </TableCell>
                      );
                    })}
                  </TableItem>
                );
              })}
              <TableItem
                id={"placeholder"}
                colSpan={columns.length}
                disabled={true}
                placeholder={true}
                onClick={() => {
                  onAdd(crypto.randomUUID());
                }}
              >
                {placeholder}
              </TableItem>
            </TableBody>
            {createPortal(
              <DragOverlay>
                {active ? (
                  <TableRoot>
                    <TableItem id={active.uuid} className="h-11">
                      {columns.map((_, index) => {
                        return <TableCell key={index} />;
                      })}
                    </TableItem>
                  </TableRoot>
                ) : null}
              </DragOverlay>,
              document.body,
            )}
          </TableRoot>
        </TableWrapper>
      </SortableContext>
    </DndContext>
  );
}

export default Table;
