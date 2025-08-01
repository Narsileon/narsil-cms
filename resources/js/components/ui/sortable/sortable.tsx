import { Card, CardContent, CardFooter } from "@narsil-cms/components/ui/card";
import { createPortal } from "react-dom";
import { get } from "lodash";
import { route } from "ziggy-js";
import { SortableAdd, SortableItem } from "@narsil-cms/components/ui/sortable";
import { useState } from "react";
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
import type { GroupedSelectOption } from "@narsil-cms/types/forms";
import type {
  DragCancelEvent,
  DragEndEvent,
  DragStartEvent,
} from "@dnd-kit/core";

type SortableProps = {
  dataPath?: string;
  direction?: "horizontal" | "vertical";
  labelKey?: string;
  items: AnonymousItem[];
  options: GroupedSelectOption[];
  setItems: (items: AnonymousItem[]) => void;
};

function Sortable({
  dataPath,
  direction = "vertical",
  items,
  labelKey = "name",
  options,
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
      const activeIndex = items.findIndex(
        (x) => x.identifier == active.id || x.id === active.id,
      );
      const overIndex = items.findIndex(
        (x) => x.identifier == over.id || x.id === over.id,
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
      (x) => x.identifier == active.id || x.id === active.id,
    ) as AnonymousItem;

    setActive(item);
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
            items={items.map((x) => x.identifier ?? x.id)}
            strategy={
              direction === "vertical"
                ? verticalListSortingStrategy
                : horizontalListSortingStrategy
            }
          >
            <ul className="grid gap-2">
              {items.map((item) => {
                const id = item?.identifier ?? item.id;
                const label = get(
                  item,
                  dataPath ? `${dataPath}.${labelKey}` : labelKey,
                );

                return (
                  <SortableItem
                    id={id}
                    data={item}
                    label={label}
                    onRemove={() => {
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
                  id={active.identifier ?? active.id}
                  label={get(
                    active,
                    dataPath ? `${dataPath}.${labelKey}` : labelKey,
                  )}
                />
              ) : null}
            </DragOverlay>,
            document.body,
          )}
        </DndContext>
      </CardContent>
      {options?.length > 0 ? (
        <CardFooter className="flex-col gap-4 border-t">
          {options?.map((option, index) => {
            return (
              <SortableAdd
                dataPath={dataPath}
                href={
                  option.routes?.create
                    ? route(option.routes.create)
                    : undefined
                }
                initialOptions={option.options}
                items={items}
                label={option.label}
                labelKey={labelKey}
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
