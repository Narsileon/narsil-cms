import { createPortal } from "react-dom";
import { CSS } from "@dnd-kit/utilities";
import { getProjection } from "@narsil-cms/lib/sortable";
import { SortableItem } from ".";
import { useEffect, useRef, useState } from "react";
import {
  closestCenter,
  defaultDropAnimation,
  DndContext,
  DragOverlay,
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
import type {
  DragCancelEvent,
  DragEndEvent,
  DragMoveEvent,
  DragOverEvent,
  DragStartEvent,
  DropAnimation,
  Modifier,
  UniqueIdentifier,
} from "@dnd-kit/core";
import type { FlatNode } from ".";

type SortableProps = {
  children?: React.ReactNode;
  items: FlatNode[];
  setItems: (items: FlatNode[]) => void;
};

const adjustTranslate: Modifier = ({ transform }) => {
  return {
    ...transform,
    y: transform.y - 25,
  };
};

const dropAnimationConfig: DropAnimation = {
  keyframes({ transform }) {
    return [
      { opacity: 1, transform: CSS.Transform.toString(transform.initial) },
      {
        opacity: 0,
        transform: CSS.Transform.toString({
          ...transform.final,
          x: transform.final.x + 5,
          y: transform.final.y + 5,
        }),
      },
    ];
  },
  easing: "ease-out",
  sideEffects({ active }) {
    active.node.animate([{ opacity: 0 }, { opacity: 1 }], {
      duration: defaultDropAnimation.duration,
      easing: defaultDropAnimation.easing,
    });
  },
};

function Sortable({ children, items, setItems }: SortableProps) {
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
        {items.map((item) => (
          <SortableItem
            item={{
              ...item,
              depth:
                item.id === activeId && projected
                  ? projected.depth
                  : item.depth,
            }}
            key={item.id}
          >
            {item.id}
          </SortableItem>
        ))}
        {createPortal(
          <DragOverlay
            dropAnimation={dropAnimationConfig}
            modifiers={[adjustTranslate]}
          >
            {activeId && activeItem ? <SortableItem item={activeItem} /> : null}
          </DragOverlay>,
          document.body,
        )}
      </SortableContext>
    </DndContext>
  );
}

export default Sortable;
