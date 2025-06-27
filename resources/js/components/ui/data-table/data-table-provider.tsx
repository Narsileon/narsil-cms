import { arrayMove } from "@dnd-kit/sortable";
import { DataTableContext } from "./data-table-context";
import { DataTableStoreType } from "@/stores/data-table-store";
import { restrictToHorizontalAxis } from "@dnd-kit/modifiers";
import { Table } from "@tanstack/react-table";
import {
  closestCenter,
  DndContext,
  KeyboardSensor,
  MouseSensor,
  TouchSensor,
  useSensor,
  useSensors,
} from "@dnd-kit/core";
import type { DragEndEvent } from "@dnd-kit/core";

export interface DataTableProviderProps {
  children: React.ReactNode;
  table: Table<any>;
  tableStore: DataTableStoreType;
}

const DataTableProvider = ({
  children,
  table,
  tableStore,
}: DataTableProviderProps) => {
  const sensors = useSensors(
    useSensor(MouseSensor, {}),
    useSensor(TouchSensor, {}),
    useSensor(KeyboardSensor, {}),
  );

  function handleDragEnd(event: DragEndEvent) {
    const { active, over } = event;

    if (active && over && active.id !== over.id) {
      table.setColumnOrder((columnOrder) => {
        const activeIndex = columnOrder.indexOf(active.id as string);
        const overIndex = columnOrder.indexOf(over.id as string);

        return arrayMove(columnOrder, activeIndex, overIndex);
      });
    }
  }

  return (
    <DataTableContext.Provider
      value={{
        table: table,
        tableStore: tableStore,
      }}
    >
      <DndContext
        collisionDetection={closestCenter}
        modifiers={[restrictToHorizontalAxis]}
        onDragEnd={handleDragEnd}
        sensors={sensors}
      >
        {children}
      </DndContext>
    </DataTableContext.Provider>
  );
};

export default DataTableProvider;
