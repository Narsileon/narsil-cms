import { arrayMove } from "@dnd-kit/sortable";
import { FlatNode } from ".";
import { getProjection } from "@narsil-cms/lib/sortable";
import { SortableContext } from "./sortable-context";
import { useEffect, useRef } from "react";
import useSortableStore from "@narsil-cms/stores/sortable-store";
import {
  closestCenter,
  DndContext,
  KeyboardSensor,
  MouseSensor,
  TouchSensor,
  useSensor,
  useSensors,
} from "@dnd-kit/core";
import type {
  DragCancelEvent,
  DragEndEvent,
  DragMoveEvent,
  DragOverEvent,
  DragStartEvent,
} from "@dnd-kit/core";
import { useStore } from "zustand";

type SortableProviderProps = {
  children: React.ReactNode;
  items: FlatNode[];
};

function SortableProvider({ children, items }: SortableProviderProps) {
  const storeRef = useRef(useSortableStore({ items }));

  const sortableStore = useStore(storeRef.current);

  const sensors = useSensors(
    useSensor(MouseSensor, {}),
    useSensor(TouchSensor, {}),
    useSensor(KeyboardSensor, {}),
  );

  const projected =
    sortableStore.activeId && sortableStore.overId
      ? getProjection(
          items,
          sortableStore.activeId,
          sortableStore.overId,
          sortableStore.offset,
          20,
        )
      : null;

  function handleDragStart({ active }: DragStartEvent) {
    sortableStore.setActiveId(active.id);
    sortableStore.setOverId(active.id);
  }

  function handleDragCancel({}: DragCancelEvent) {
    resetState();
  }

  function handleDragEnd({ active, over }: DragEndEvent) {
    resetState();
    if (!projected || !over) {
      return;
    }

    const clonedItems: FlatNode[] = JSON.parse(JSON.stringify(items));

    const activeIndex = clonedItems.findIndex(({ id }) => id === active.id);
    const overIndex = clonedItems.findIndex(({ id }) => id === over.id);

    const { depth, parentId } = projected;

    const activeTreeItem = clonedItems[activeIndex];

    clonedItems[activeIndex] = {
      ...activeTreeItem,
      depth,
      parent_id: parentId,
    };

    const sortedItems = arrayMove(clonedItems, activeIndex, overIndex);

    sortableStore.setItems(sortedItems);
  }

  function handleDragMove({ delta }: DragMoveEvent) {
    sortableStore.setOffset(delta.x);
  }

  function handleDragOver({ over }: DragOverEvent) {
    sortableStore.setOverId(over?.id ?? null);
  }

  function resetState() {
    sortableStore.setActiveId(null);
    sortableStore.setOffset(0);
    sortableStore.setOverId(null);
  }

  useEffect(() => {
    if (!projected) return;

    const { depth, parentId } = projected;

    if (sortableStore.depth !== depth) {
      sortableStore.setDepth(depth);
    }

    if (sortableStore.parentId !== parentId) {
      sortableStore.setParentId(parentId);
    }
  }, [projected, sortableStore]);

  return (
    <SortableContext.Provider value={sortableStore}>
      <DndContext
        collisionDetection={closestCenter}
        onDragCancel={handleDragCancel}
        onDragEnd={handleDragEnd}
        onDragMove={handleDragMove}
        onDragOver={handleDragOver}
        onDragStart={handleDragStart}
        sensors={sensors}
      >
        {children}
      </DndContext>
    </SortableContext.Provider>
  );
}

export default SortableProvider;
