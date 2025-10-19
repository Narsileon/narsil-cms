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
import { Button } from "@narsil-cms/blocks";
import { useLocalization } from "@narsil-cms/components/localization";
import type { Block } from "@narsil-cms/types";
import { useState } from "react";
import { createPortal } from "react-dom";
import { ArrayItem, type ArrayElement } from ".";

type ArrayProps = {
  block: Block;
  id: string;
  items: ArrayElement[];
  labelKey: string;
  setItems: (items: ArrayElement[]) => void;
};

function Array({ block, id, items, labelKey, setItems }: ArrayProps) {
  const { trans } = useLocalization();

  const [active, setActive] = useState<ArrayElement | null>(null);

  const sensors = useSensors(
    useSensor(MouseSensor),
    useSensor(TouchSensor),
    useSensor(KeyboardSensor),
  );

  function onDragCancel({}: DragCancelEvent) {
    setActive(null);
  }

  function onDragEnd({ active, over }: DragEndEvent) {
    if (over) {
      const activeIndex = items.findIndex((item) => item.uuid === active.id);
      const overIndex = items.findIndex((item) => item.uuid === over.id);

      if (activeIndex !== overIndex) {
        setItems(arrayMove(items, activeIndex, overIndex));
      }
    }

    setActive(null);
  }

  function onDragStart({ active }: DragStartEvent) {
    const item = items.find((item) => item.uuid === active.id) as ArrayElement;
    setActive(item);
  }

  return (
    <div>
      <DndContext
        collisionDetection={closestCenter}
        sensors={sensors}
        onDragCancel={onDragCancel}
        onDragEnd={onDragEnd}
        onDragStart={onDragStart}
      >
        <SortableContext
          items={items.map((item) => item.uuid)}
          strategy={verticalListSortingStrategy}
        >
          <ul className="grid gap-4">
            {items.map((item, index) => {
              return (
                <ArrayItem
                  block={block}
                  handle={id}
                  id={item.uuid}
                  index={index}
                  item={item}
                  labelKey={labelKey}
                  onItemRemove={() => {
                    setItems(items.filter((x) => x.uuid !== item.uuid));
                  }}
                  key={item.uuid}
                />
              );
            })}
          </ul>
        </SortableContext>
        {createPortal(
          <DragOverlay>
            {active ? <ArrayItem id={active.uuid} item={active} labelKey={labelKey} /> : null}
          </DragOverlay>,
          document.body,
        )}
      </DndContext>
      <Button
        className="mt-4"
        onClick={() => setItems([...items, { uuid: crypto.randomUUID(), [labelKey]: "" }])}
      >
        {trans("ui.add")}
      </Button>
    </div>
  );
}

export default Array;
