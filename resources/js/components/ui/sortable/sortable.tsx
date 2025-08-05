import * as React from "react";
import { Card, CardContent, CardFooter } from "@narsil-cms/components/ui/card";
import { createPortal } from "react-dom";
import { SortableAdd, SortableItem } from "@narsil-cms/components/ui/sortable";
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
import type { Field, GroupedSelectOption } from "@narsil-cms/types/forms";
import type {
  DragCancelEvent,
  DragEndEvent,
  DragStartEvent,
} from "@dnd-kit/core";

type SortableProps = {
  direction?: "horizontal" | "vertical";
  form?: Field[];
  items: AnonymousItem[];
  options: GroupedSelectOption[];
  unique?: boolean;
  setItems: (items: AnonymousItem[]) => void;
};

function Sortable({
  direction = "vertical",
  form,
  items,
  options,
  unique,
  setItems,
}: SortableProps) {
  const [active, setActive] = React.useState<AnonymousItem | null>(null);

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
      const activeIndex = items.findIndex(
        (item) => getUniqueIdentifier(item) == active.id,
      );
      const overIndex = items.findIndex(
        (item) => getUniqueIdentifier(item) == over.id,
      );

      if (activeIndex !== overIndex) {
        setItems(arrayMove(items, activeIndex, overIndex));
      }
    }
  }

  function onDragStart({ active }: DragStartEvent) {
    if (!active) {
      return;
    }

    const item = items.find(
      (item) => getUniqueIdentifier(item) == active.id,
    ) as AnonymousItem;

    setActive(item);
  }

  function getGroup(item: AnonymousItem) {
    const group = options.find((x) =>
      item.identifier.includes(x.identifier),
    ) as GroupedSelectOption;

    return group;
  }

  function getFormattedLabel(item: AnonymousItem) {
    const group = getGroup(item);

    return `${item[group.optionLabel]} (${item[group.optionValue]})`;
  }

  function getUniqueIdentifier(item: AnonymousItem) {
    const group = getGroup(item);

    return item[group.optionValue];
  }

  return (
    <Card>
      <CardContent>
        <DndContext
          collisionDetection={closestCenter}
          sensors={sensors}
          onDragCancel={onDragCancel}
          onDragEnd={onDragEnd}
          onDragStart={onDragStart}
        >
          <SortableContext
            items={items.map((item) => getUniqueIdentifier(item))}
            strategy={
              direction === "vertical"
                ? verticalListSortingStrategy
                : horizontalListSortingStrategy
            }
          >
            <ul className="grid gap-2">
              {items.map((item) => {
                const id = getUniqueIdentifier(item);
                const label = getFormattedLabel(item);

                return (
                  <SortableItem
                    id={id}
                    form={form}
                    group={getGroup(item)}
                    item={item}
                    label={label}
                    onItemChange={(value: AnonymousItem) => {
                      setItems(
                        items.map((x) =>
                          getUniqueIdentifier(x) === id ? value : x,
                        ),
                      );
                    }}
                    onItemRemove={() => {
                      setItems(items.filter((x) => x !== item));
                    }}
                    key={id}
                  />
                );
              })}
            </ul>
          </SortableContext>
          {createPortal(
            <DragOverlay>
              {active ? (
                <SortableItem
                  id={getUniqueIdentifier(active)}
                  group={getGroup(active)}
                  item={active}
                  label={getFormattedLabel(active)}
                />
              ) : null}
            </DragOverlay>,
            document.body,
          )}
        </DndContext>
      </CardContent>
      {options?.length > 0 ? (
        <CardFooter className="flex-col gap-4 border-t">
          {options?.map((group, index) => {
            return (
              <SortableAdd
                items={items}
                group={group}
                unique={unique}
                setItems={setItems}
                key={index}
              />
            );
          })}
        </CardFooter>
      ) : null}
    </Card>
  );
}

export default Sortable;
