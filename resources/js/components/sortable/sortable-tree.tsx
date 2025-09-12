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
  type DragMoveEvent,
  type DragOverEvent,
  type DragStartEvent,
  type UniqueIdentifier,
} from "@dnd-kit/core";
import {
  arrayMove,
  SortableContext,
  verticalListSortingStrategy,
} from "@dnd-kit/sortable";
import { useEffect, useRef, useState } from "react";
import { createPortal } from "react-dom";

import { getProjection } from "@narsil-cms/lib/sortable";

import { SortableItem, type FlatNode } from ".";

type SortableProps = {
  items: FlatNode[];
  setItems: (items: FlatNode[]) => void;
};

function Sortable({ items, setItems }: SortableProps) {
  const [activeId, setActiveId] = useState<UniqueIdentifier | null>(null);
  const [overId, setOverId] = useState<UniqueIdentifier | null>(null);
  const [offsetLeft, setOffsetLeft] = useState(0);

  const projected =
    activeId && overId
      ? getProjection(items, activeId, overId, offsetLeft, 20)
      : null;

  const activeItem = activeId ? items.find(({ id }) => id === activeId) : null;

  const sensors = useSensors(
    useSensor(MouseSensor, {}),
    useSensor(TouchSensor, {}),
    useSensor(KeyboardSensor, {}),
  );
  const sensorContext = useRef({
    items: items,
    offset: offsetLeft,
  });

  function handleDragStart({ active }: DragStartEvent) {
    setActiveId(active.id);
    setOverId(active.id);

    document.body.style.setProperty("cursor", "grabbing");
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

    setItems(sortedItems);
  }

  function handleDragMove({ delta }: DragMoveEvent) {
    setOffsetLeft(delta.x);
  }

  function handleDragOver({ over }: DragOverEvent) {
    setOverId(over?.id ?? null);
  }

  function resetState() {
    setActiveId(null);
    setOffsetLeft(0);
    setOverId(null);

    document.body.style.setProperty("cursor", "");
  }

  useEffect(() => {
    sensorContext.current = {
      items: items,
      offset: offsetLeft,
    };
  }, [items, offsetLeft]);

  return (
    <DndContext
      collisionDetection={closestCenter}
      onDragCancel={handleDragCancel}
      onDragEnd={handleDragEnd}
      onDragMove={handleDragMove}
      onDragOver={handleDragOver}
      onDragStart={handleDragStart}
      sensors={sensors}
    >
      <SortableContext items={items} strategy={verticalListSortingStrategy}>
        {items.map((item) => {
          const depth =
            item.id === activeId && projected ? projected.depth : item.depth;

          return (
            <SortableItem
              label={item.id.toString()}
              id={item.id}
              style={{ marginLeft: `${depth * 16}px` }}
              key={item.id}
            />
          );
        })}
        {createPortal(
          <DragOverlay>
            {activeId && activeItem ? (
              <SortableItem id={activeItem.id} />
            ) : null}
          </DragOverlay>,
          document.body,
        )}
      </SortableContext>
    </DndContext>
  );
}

export default Sortable;
