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
import { SortableAdd, type AnonymousItem } from ".";
import type {
  DragCancelEvent,
  DragEndEvent,
  DragStartEvent,
} from "@dnd-kit/core";

type SortableProps = {
  create?: string;
  direction?: "horizontal" | "vertical";
  labelKey?: string;
  items: AnonymousItem[];
  setItems: (items: AnonymousItem[]) => void;
};

function Sortable({
  create,
  direction = "vertical",
  labelKey = "name",
  items,
  setItems,
}: SortableProps) {
  const [active, setActive] = useState<AnonymousItem | null>(null);

  function getIndex(item: AnonymousItem) {
    return items.indexOf(item);
  }

  const activeIndex = active ? getIndex(active) : -1;

  const sensors = useSensors(
    useSensor(MouseSensor, {}),
    useSensor(TouchSensor, {}),
    useSensor(KeyboardSensor, {}),
  );

  function onDragCancel({}: DragCancelEvent) {
    setActive(null);
  }

  function onDragEnd({ over }: DragEndEvent) {
    setActive(null);

    if (over) {
      const overIndex = getIndex(over);

      if (activeIndex !== overIndex) {
        setItems(arrayMove(items, activeIndex, overIndex));
      }
    }
  }

  function onDragStart({ active }: DragStartEvent) {
    if (!active) {
      return;
    }

    setActive(active);
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
      {create ? <SortableAdd href={create} /> : null}
    </DndContext>
  );
}

export default Sortable;
