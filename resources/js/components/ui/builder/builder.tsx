import * as React from "react";
import { useState } from "react";
import BuilderAdd from "./builder-add";
import BuilderItem from "./builder-item";
import BuilderSeparator from "./builder-seperator";
import {
  closestCenter,
  DndContext,
  DragOverlay,
  MouseSensor,
  TouchSensor,
  KeyboardSensor,
  useSensor,
  useSensors,
} from "@dnd-kit/core";
import {
  arrayMove,
  SortableContext,
  verticalListSortingStrategy,
} from "@dnd-kit/sortable";
import type { Block } from "@narsil-cms/types/forms";
import type {
  DragCancelEvent,
  DragEndEvent,
  DragStartEvent,
} from "@dnd-kit/core";

type BuilderProps = {
  blocks: Block[];
  items: Block[];
  setItems: (items: Block[]) => void;
};

function Builder({ blocks, items, setItems }: BuilderProps) {
  const [active, setActive] = useState<Block | null>(null);

  const sensors = useSensors(
    useSensor(MouseSensor),
    useSensor(TouchSensor),
    useSensor(KeyboardSensor),
  );

  function onDragCancel({}: DragCancelEvent) {
    setActive(null);
  }

  function onDragEnd({ active, over }: DragEndEvent) {
    setActive(null);

    if (over) {
      const activeIndex = items.findIndex((item) => item.id == active.id);
      const overIndex = items.findIndex((item) => item.id == over.id);

      if (activeIndex !== overIndex) {
        setItems(arrayMove(items, activeIndex, overIndex));
      }
    }
  }

  function onDragStart({ active }: DragStartEvent) {
    const item = items.find((item) => item.id === active.id);

    if (item) {
      setActive(item);
    }
  }

  return (
    <DndContext
      sensors={sensors}
      collisionDetection={closestCenter}
      onDragCancel={onDragCancel}
      onDragEnd={onDragEnd}
      onDragStart={onDragStart}
    >
      <SortableContext items={items} strategy={verticalListSortingStrategy}>
        <div className="flex flex-col items-center justify-center">
          <div className="bg-constructive size-4 rounded-full" />
          <BuilderSeparator />
          {items.map((item, index) => (
            <React.Fragment key={index}>
              <BuilderAdd
                blocks={blocks}
                onAdd={(item) => {
                  const newItems = [...items];

                  newItems.splice(index, 0, item);

                  setItems(newItems);
                }}
              />
              <BuilderSeparator />
              <BuilderItem item={item} key={item.id} />
              <BuilderSeparator />
            </React.Fragment>
          ))}
          <BuilderAdd
            blocks={blocks}
            onAdd={(block) => setItems([...items, block])}
          />
          <BuilderSeparator />
          <div className="bg-destructive size-4 rounded-full" />
        </div>
      </SortableContext>
      <DragOverlay>{active ? <BuilderItem item={active} /> : null}</DragOverlay>
    </DndContext>
  );
}

export default Builder;
