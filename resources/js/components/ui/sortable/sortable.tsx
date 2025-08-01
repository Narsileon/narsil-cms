import { createPortal } from "react-dom";
import { get } from "lodash";
import { useState } from "react";
import SortableItem from "./sortable-item";
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
  horizontalListSortingStrategy,
  SortableContext,
  verticalListSortingStrategy,
} from "@dnd-kit/sortable";
import type { AnonymousItem } from ".";
import type {
  DragCancelEvent,
  DragEndEvent,
  DragStartEvent,
} from "@dnd-kit/core";

type SortableProps = {
  direction?: "horizontal" | "vertical";
  labelKey?: string;
  items: AnonymousItem[];
  setItems: (items: AnonymousItem[]) => void;
};

function Sortable({
  direction = "vertical",
  labelKey = "name",
  items,
  setItems,
}: SortableProps) {
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

    setActive(items.find((x) => x.id === active.id) as AnonymousItem);
  }

  return (
    <DndContext
      collisionDetection={closestCenter}
      sensors={sensors}
      onDragCancel={onDragCancel}
      onDragEnd={onDragEnd}
      onDragStart={onDragStart}
    >
      <SortableContext
        items={items}
        strategy={
          direction === "vertical"
            ? verticalListSortingStrategy
            : horizontalListSortingStrategy
        }
      >
        <ul className="grid gap-2">
          {items.map((item) => (
            <SortableItem
              key={item.id}
              id={item.id}
              label={get(item, labelKey)}
              onRemove={() => {
                setItems(items.filter((x) => x.id !== item.id));
              }}
            />
          ))}
        </ul>
      </SortableContext>
      {createPortal(
        <DragOverlay>
          {active ? (
            <SortableItem id={active.id} label={get(active, labelKey)} />
          ) : null}
        </DragOverlay>,
        document.body,
      )}
    </DndContext>
  );
}

export default Sortable;
