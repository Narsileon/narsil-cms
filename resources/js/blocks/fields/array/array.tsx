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
import { Button } from "@narsil-cms/components/button";
import { useLocalization } from "@narsil-cms/components/localization";
import type { Element } from "@narsil-cms/types";
import { useState } from "react";
import { createPortal } from "react-dom";
import { ArrayItem, type ArrayElement } from ".";

type ArrayProps = {
  form: Element[];
  id: string;
  items: ArrayElement[];
  labelKey: string;
  setItems: (items: ArrayElement[]) => void;
};

function Array({ form, id, items, labelKey, setItems }: ArrayProps) {
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
    const item = items.find((item) => item.uuid === active.id);

    setActive(item as ArrayElement);
  }

  function onMoveUp(uuid: string) {
    const index = items.findIndex((item) => item.uuid === uuid);

    if (index > 0) {
      setItems(arrayMove(items, index, index - 1));
    }
  }

  function onMoveDown(uuid: string) {
    const index = items.findIndex((item) => item.uuid === uuid);

    if (index !== -1 && index < items.length - 1) {
      setItems(arrayMove(items, index, index + 1));
    }
  }

  function onRemove(uuid: string) {
    setItems(items.filter((item) => item.uuid !== uuid));
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
                  form={form}
                  handle={id}
                  id={item.uuid}
                  index={index}
                  item={item}
                  labelKey={labelKey}
                  onMoveDown={index < items.length - 1 ? () => onMoveDown(item.uuid) : undefined}
                  onMoveUp={index !== 0 ? () => onMoveUp(item.uuid) : undefined}
                  onRemove={() => onRemove(item.uuid)}
                  key={item.uuid}
                />
              );
            })}
          </ul>
        </SortableContext>
        {createPortal(
          <DragOverlay>
            {active ? (
              <ArrayItem id={active.uuid} form={form} item={active} labelKey={labelKey} />
            ) : null}
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
