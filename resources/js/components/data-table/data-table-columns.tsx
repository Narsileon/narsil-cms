import { closestCenter, DndContext, type DragEndEvent } from "@dnd-kit/core";
import {
  arrayMove,
  SortableContext,
  verticalListSortingStrategy,
  useSortable,
} from "@dnd-kit/sortable";
import { CSS } from "@dnd-kit/utilities";
import { Column } from "@tanstack/react-table";
import { upperFirst } from "lodash";
import { ComponentProps } from "react";

import { Button, Card } from "@narsil-cms/blocks";
import { useDataTable } from "@narsil-cms/components/data-table";
import { useLabels } from "@narsil-cms/components/labels";
import {
  PopoverRoot,
  PopoverContent,
  PopoverTrigger,
  PopoverPortal,
} from "@narsil-cms/components/popover";
import { SortableHandle } from "@narsil-cms/components/sortable";
import type { Model } from "@narsil-cms/types";

type DataTableColumnsProps = ComponentProps<typeof PopoverTrigger> & {};

function DataTableColumns({ children, ...props }: DataTableColumnsProps) {
  const { trans } = useLabels();

  const { dataTable } = useDataTable();

  const activeColumns = dataTable
    .getAllLeafColumns()
    .filter((column) => column.getIsVisible() && column.getCanHide());

  const availableColumns = dataTable
    .getAllLeafColumns()
    .filter((column) => !column.getIsVisible() && column.getCanHide());

  function handleActivate(column: Column<Model, unknown>) {
    column.toggleVisibility(true);

    const originalOrder = dataTable.getState().columnOrder ?? [];

    const filteredOrder = originalOrder.filter((id) => id !== column.id);

    const newOrder = [...filteredOrder, column.id];

    dataTable.setColumnOrder(newOrder);
  }

  function handleDeactivate(column: Column<Model, unknown>) {
    column.toggleVisibility(false);

    const originalOrder = dataTable.getState().columnOrder ?? [];

    const newOrder = originalOrder.filter((id) => id !== column.id);

    dataTable.setColumnOrder(newOrder);
  }

  function handleDragEnd(event: DragEndEvent) {
    const { active, over } = event;

    if (!over || active.id === over.id) {
      return;
    }

    const currentOrder = dataTable.getState().columnOrder;

    const oldIndex = currentOrder.indexOf(active.id as string);
    const newIndex = currentOrder.indexOf(over.id as string);

    if (oldIndex === -1 || newIndex === -1) {
      return;
    }

    const newOrder = arrayMove(currentOrder, oldIndex, newIndex);

    dataTable.setColumnOrder(newOrder);
  }

  return (
    <PopoverRoot>
      <PopoverTrigger asChild={true} {...props}>
        {children}
      </PopoverTrigger>
      <PopoverPortal>
        <PopoverContent className="grid w-96 grid-cols-2 overflow-y-hidden border-none p-0">
          <Card
            className="rounded-r-none border-r-0"
            contentProps={{ className: "gap-y-1" }}
            headerProps={{ className: "border-b" }}
            title={trans("ui.available_columns", "Available columns")}
          >
            {availableColumns.map((column) => (
              <Button
                className="justify-start font-normal"
                tooltip={trans("accessibility.show_column", "Show column")}
                variant="outline"
                onClick={() => handleActivate(column)}
                key={column.id}
              >
                {upperFirst(column.columnDef.header as string)}
              </Button>
            ))}
          </Card>
          <Card
            className="rounded-l-none"
            contentProps={{ className: "gap-y-1" }}
            headerProps={{ className: "border-b" }}
            title={trans("ui.active_columns", "Active columns")}
          >
            <DndContext
              collisionDetection={closestCenter}
              onDragEnd={handleDragEnd}
            >
              <SortableContext
                items={activeColumns.map((column) => column.id)}
                strategy={verticalListSortingStrategy}
              >
                {activeColumns.map((column) => (
                  <SortableItem
                    key={column.id}
                    column={column}
                    onRemove={() => handleDeactivate(column)}
                  />
                ))}
              </SortableContext>
            </DndContext>
          </Card>
        </PopoverContent>
      </PopoverPortal>
    </PopoverRoot>
  );
}

export default DataTableColumns;

type SortableItemProps = {
  column: Column<Model, unknown>;
  onRemove: (c: Column<Model, unknown>) => void;
};

function SortableItem({ column, onRemove }: SortableItemProps) {
  const { trans } = useLabels();

  const {
    attributes,
    isDragging,
    listeners,
    setNodeRef,
    transform,
    transition,
  } = useSortable({
    id: column.id,
  });

  const columnLabel = upperFirst(column.columnDef.header as string);

  const hideColumnLabel = `${trans("ui.hide", "Hide")} ${columnLabel}`;
  const moveClumnLabel = `${trans("ui.move", "Move")} ${columnLabel}`;

  return (
    <div
      className="bg-background flex h-9 items-center gap-2 overflow-hidden rounded-md border pr-1"
      style={{
        transform: CSS.Transform.toString(transform),
        transition,
      }}
    >
      <SortableHandle
        ref={setNodeRef}
        {...attributes}
        {...listeners}
        isDragging={isDragging}
        tooltipProps={{
          contentProps: {
            hidden: isDragging,
          },
          tooltip: moveClumnLabel,
        }}
      />
      <span className="grow">{columnLabel}</span>
      <Button
        className="size-7"
        iconProps={{
          className: "size-4",
          name: "x",
        }}
        size="icon"
        tooltip={hideColumnLabel}
        variant="ghost"
        onClick={() => onRemove(column)}
      />
    </div>
  );
}
