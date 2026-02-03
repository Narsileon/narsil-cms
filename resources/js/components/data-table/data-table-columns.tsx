import { closestCenter, DndContext, type DragEndEvent } from "@dnd-kit/core";
import {
  arrayMove,
  SortableContext,
  useSortable,
  verticalListSortingStrategy,
} from "@dnd-kit/sortable";
import { CSS } from "@dnd-kit/utilities";
import { Button } from "@narsil-cms/components/button";
import { CardContent, CardHeader, CardRoot, CardTitle } from "@narsil-cms/components/card";
import { useDataTable } from "@narsil-cms/components/data-table";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import {
  PopoverPopup,
  PopoverPortal,
  PopoverPositioner,
  PopoverRoot,
  PopoverTrigger,
} from "@narsil-cms/components/popover";
import { SortableHandle } from "@narsil-cms/components/sortable";
import { Tooltip } from "@narsil-cms/components/tooltip";
import type { Model } from "@narsil-cms/types";
import { type Column } from "@tanstack/react-table";
import { concat, upperFirst } from "lodash-es";
import { type ComponentProps } from "react";

type DataTableColumnsProps = ComponentProps<typeof PopoverTrigger>;

function DataTableColumns({ ...props }: DataTableColumnsProps) {
  const { trans } = useLocalization();

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

    const menuIndex = filteredOrder.indexOf("_menu");

    const newOrder =
      menuIndex === -1
        ? concat(filteredOrder, column.id)
        : concat(filteredOrder.slice(0, menuIndex), column.id, filteredOrder.slice(menuIndex));

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
    <PopoverRoot modal={true}>
      <PopoverTrigger {...props} />
      <PopoverPortal>
        <PopoverPositioner>
          <PopoverPopup className="grid max-h-96 min-w-fit border-collapse grid-cols-2 overflow-y-scroll p-0">
            <CardRoot className="rounded-none border-0">
              <CardHeader className="border-b">
                <CardTitle>{trans("ui.available_columns")}</CardTitle>
              </CardHeader>
              <CardContent className="gap-y-1">
                {availableColumns.map((column) => {
                  const columnLabel = upperFirst(column.columnDef.header as string);
                  const label = `${trans("ui.show")} '${columnLabel}'`;

                  return (
                    <Tooltip tooltip={label}>
                      <Button
                        aria-label={label}
                        className="justify-start font-normal"
                        variant="outline"
                        onClick={() => handleActivate(column)}
                        key={column.id}
                      >
                        {upperFirst(column.columnDef.header as string)}
                      </Button>
                    </Tooltip>
                  );
                })}
              </CardContent>
            </CardRoot>
            <CardRoot className="rounded-none border-y-0">
              <CardHeader className="border-b">
                <CardTitle>{trans("ui.active_columns")}</CardTitle>
              </CardHeader>
              <CardContent className="gap-y-1">
                <DndContext collisionDetection={closestCenter} onDragEnd={handleDragEnd}>
                  <SortableContext
                    items={activeColumns.map((column) => column.id)}
                    strategy={verticalListSortingStrategy}
                  >
                    {activeColumns.map((column) => {
                      return (
                        <SortableItem
                          key={column.id}
                          column={column}
                          onRemove={() => handleDeactivate(column)}
                        />
                      );
                    })}
                  </SortableContext>
                </DndContext>
              </CardContent>
            </CardRoot>
          </PopoverPopup>
        </PopoverPositioner>
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
  const { trans } = useLocalization();

  const { attributes, isDragging, listeners, setNodeRef, transform, transition } = useSortable({
    id: column.id,
  });

  const columnLabel = upperFirst(column.columnDef.header as string);

  const hideColumnLabel = `${trans("ui.hide")} '${columnLabel}'`;
  const moveColumnLabel = `${trans("ui.move")} '${columnLabel}'`;

  return (
    <div
      className="flex h-9 items-center gap-2 overflow-hidden rounded-md border bg-background pr-1"
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
        label={moveColumnLabel}
      />
      <span className="grow">{columnLabel}</span>
      <Tooltip tooltip={hideColumnLabel}>
        <Button
          aria-label={hideColumnLabel}
          size="icon-sm"
          variant="ghost"
          onClick={() => onRemove(column)}
        >
          <Icon className="size-4" name="x" />
        </Button>
      </Tooltip>
    </div>
  );
}
