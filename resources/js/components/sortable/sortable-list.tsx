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
import { arrayMove } from "@dnd-kit/sortable";
import { SortableAdd, SortableItem, SortableListContext } from "@narsil-cms/components/sortable";
import type { GroupedSelectOption } from "@narsil-cms/types";
import { BackgroundGrid, BackgroundRoot } from "@narsil-ui/components/background";
import { CardContent, CardFooter, CardRoot } from "@narsil-ui/components/card";
import { useTranslator } from "@narsil-ui/components/translator";
import { getTranslatableData, getUntranslatableData } from "@narsil-ui/lib/data";
import { useState, type ComponentProps } from "react";
import { createPortal } from "react-dom";
import { type AnonymousItem } from ".";

type SortableProps = ComponentProps<typeof SortableListContext>;

function Sortable({ items, options, unique, setItems, ...props }: SortableProps) {
  const { locale } = useTranslator();

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
    if (over) {
      const activeIndex = items.findIndex((item) => getUniqueIdentifier(item) == active.id);
      const overIndex = items.findIndex((item) => getUniqueIdentifier(item) == over.id);

      if (activeIndex !== overIndex) {
        setItems(arrayMove(items, activeIndex, overIndex));
      }
    }

    setActive(null);
  }

  function onDragStart({ active }: DragStartEvent) {
    const item = items.find((item) => getUniqueIdentifier(item) == active.id) as AnonymousItem;

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

    const label = getTranslatableData(item, group.optionLabel, locale);
    const value = getUntranslatableData(item, group.optionValue);

    return unique ? label : `${label} (${value})`;
  }

  function getUniqueIdentifier(item: AnonymousItem) {
    const group = getGroup(item);

    return getUntranslatableData(item, group.optionValue);
  }

  return (
    <CardRoot>
      <CardContent className="relative">
        <DndContext
          collisionDetection={closestCenter}
          sensors={sensors}
          onDragCancel={onDragCancel}
          onDragEnd={onDragEnd}
          onDragStart={onDragStart}
        >
          <SortableListContext
            items={items}
            options={options}
            unique={unique}
            setItems={setItems}
            {...props}
          />
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
        <BackgroundRoot>
          <BackgroundGrid id="sortable-list" />
        </BackgroundRoot>
      </CardContent>
      {options?.length > 0 ? (
        <CardFooter className="flex-col gap-4 border-t">
          {options?.map((group, index) => {
            return (
              <SortableAdd
                ids={items.map((item) => getUniqueIdentifier(item))}
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
    </CardRoot>
  );
}

export default Sortable;
