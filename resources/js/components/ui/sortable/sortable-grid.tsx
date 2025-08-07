import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { createPortal } from "react-dom";
import { get } from "lodash";
import {
  CancelDrop,
  DndContext,
  DragEndEvent,
  DragOverEvent,
  DragOverlay,
  DragStartEvent,
  KeyboardSensor,
  MouseSensor,
  TouchSensor,
  UniqueIdentifier,
  useSensor,
  useSensors,
} from "@dnd-kit/core";
import {
  arrayMove,
  rectSortingStrategy,
  SortableContext,
} from "@dnd-kit/sortable";
import {
  SortableAdd,
  SortableItem,
  SortableListContext,
} from "@narsil-cms/components/ui/sortable";
import type { AnonymousItem } from ".";
import type { Field, GroupedSelectOption } from "@narsil-cms/types/forms";

interface SortableGridProps {
  columns?: 1 | 2 | 3 | 4;
  form: Field[];
  items: AnonymousItem[];
  placeholder: string;
  setItems: (items: AnonymousItem[]) => void;
  cancelDrop?: CancelDrop;
}

const PLACEHOLDER_ID = "placeholder";

function SortableGrid({
  columns = 2,
  form,
  items,
  placeholder,
  cancelDrop,
  setItems,
}: SortableGridProps) {
  const [active, setActive] = React.useState<AnonymousItem | null>(null);

  const sensors = useSensors(
    useSensor(MouseSensor),
    useSensor(TouchSensor),
    useSensor(KeyboardSensor),
  );

  const onDragCancel = () => {
    setActive(null);
  };

  function onDragStart({ active }: DragStartEvent) {
    const container = items.find((item) => item.id === active.id);

    if (container) {
      setActive(container);
    } else {
      items.map((container) => {
        const children = getContainerChildren(container);

        children.map((child) => {
          if (getChildUniqueIdentifier(child) === active.id) {
            setActive(child);

            return;
          }
        });
      });
    }
  }

  function onDragEnd({ active, over }: DragEndEvent) {
    if (over) {
      const activeIndex = items.findIndex((x) => x.id === active.id);
      const overIndex = items.findIndex((x) => x.id === over.id);

      const isContainerSorting = activeIndex !== -1 && overIndex !== -1;

      if (isContainerSorting) {
        if (activeIndex !== overIndex) {
          const nextItems = arrayMove(items, activeIndex, overIndex);

          setItems(nextItems);

          setActive(null);
        }

        return;
      }

      const activeContainer = findContainerByChildIdentifier(active.id);

      if (!activeContainer) {
        setActive(null);

        return;
      }

      const overContainer = findContainerByChildIdentifier(active.id);

      if (activeContainer.id === overContainer?.id) {
        const oldIndex = getContainerChildren(activeContainer).findIndex(
          (child) => getChildUniqueIdentifier(child) === active.id,
        );
        const newIndex = getContainerChildren(activeContainer).findIndex(
          (child) => getChildUniqueIdentifier(child) === over.id,
        );

        if (oldIndex !== newIndex) {
          const updatedElements = arrayMove(
            activeContainer.elements,
            oldIndex,
            newIndex,
          );

          const updatedItems = items.map((item) =>
            item.id === activeContainer.id
              ? {
                  ...item,
                  elements: updatedElements,
                }
              : item,
          );

          setItems(updatedItems);
        }
      }
    }

    setActive(null);
  }

  function onDragOver({ active, over }: DragOverEvent) {
    if (!over) {
      return;
    }

    if (active.id === over.id) {
      return;
    }

    const activeContainer = findContainerByChildIdentifier(active.id);

    const overItem = items.find(
      (container) =>
        container.id === over.id ||
        getContainerChildren(container).some(
          (child) => getChildUniqueIdentifier(child) === over.id,
        ),
    );

    if (!activeContainer || !overItem || activeContainer.id === overItem.id) {
      return;
    }

    const activeItemIndex = getContainerChildren(activeContainer).findIndex(
      (child) => getChildUniqueIdentifier(child) === active.id,
    );
    const activeItem = getContainerChildren(activeContainer)[activeItemIndex];

    const nextItems = items.map((container) => {
      if (container.id === activeContainer.id) {
        return {
          ...container,
          [form[0].handle]: getContainerChildren(container).filter(
            (child) => getChildUniqueIdentifier(child) !== active.id,
          ),
        };
      }

      if (container.id === overItem.id) {
        return {
          ...container,
          [form[0].handle]: [...getContainerChildren(container), activeItem],
        };
      }

      return container;
    });

    setItems(nextItems);
  }

  function findContainerByChildIdentifier(identifier: UniqueIdentifier) {
    return items.find((container) =>
      getContainerChildren(container).some(
        (child) => getChildUniqueIdentifier(child) === identifier,
      ),
    );
  }

  function getContainerChildren(container: AnonymousItem) {
    const children: AnonymousItem[] = get(container, form[0].handle, []);

    return children;
  }

  function getChildGroup(child: AnonymousItem) {
    const group = form[0].settings.options?.find((option) =>
      child.identifier.includes(option.identifier),
    ) as GroupedSelectOption;

    return group;
  }

  function getChildUniqueIdentifier(child: AnonymousItem) {
    const group = getChildGroup(child);

    return child[group.optionValue];
  }

  return (
    <DndContext
      sensors={sensors}
      cancelDrop={cancelDrop}
      onDragCancel={onDragCancel}
      onDragEnd={onDragEnd}
      onDragOver={onDragOver}
      onDragStart={onDragStart}
    >
      <div className={cn(`grid-cols-${columns} grid gap-4`)}>
        <SortableContext
          items={items.map((item) => item.id)}
          strategy={rectSortingStrategy}
        >
          {items.map((item) => {
            const children = get(item, form[0].handle, []);

            return (
              <SortableItem
                id={item.id}
                item={item}
                label={item.id}
                onItemRemove={() => {
                  setItems(items.filter((x) => x !== item));
                }}
                footer={
                  <>
                    {form[0].settings.options?.map((group, index) => {
                      return (
                        <SortableAdd
                          ids={items
                            .flatMap((item) => item[form[0].handle] || [])
                            .map((x) => x.handle)}
                          items={children}
                          group={group}
                          setItems={(groupItems) => {
                            const updatedItems = items.map((x) =>
                              x.id === item.id
                                ? {
                                    ...x,
                                    [form[0].handle]: groupItems,
                                  }
                                : x,
                            );
                            setItems(updatedItems);
                          }}
                          key={index}
                        />
                      );
                    })}
                  </>
                }
                key={item.id}
              >
                <SortableListContext
                  items={children}
                  options={form[0].settings.options}
                  setItems={(groupItems) => {
                    const updatedItems = items.map((x) =>
                      x.id === item.id
                        ? {
                            ...x,
                            [form[0].handle]: groupItems,
                          }
                        : x,
                    );
                    setItems(updatedItems);
                  }}
                />
              </SortableItem>
            );
          })}
          <SortableItem
            id={PLACEHOLDER_ID}
            placeholder={true}
            item={{ id: PLACEHOLDER_ID, identifier: PLACEHOLDER_ID }}
            onClick={handleAddColumn}
          >
            {placeholder}
          </SortableItem>
        </SortableContext>
      </div>
      {createPortal(
        <DragOverlay>
          {active ? (
            items.some((x) => x.id === active.id) ? (
              <SortableItem
                id={active.id}
                item={active}
                label={`Column ${active.name}`}
              ></SortableItem>
            ) : (
              <SortableItem id={active.id} item={active} label={active.name} />
            )
          ) : null}
        </DragOverlay>,
        document.body,
      )}
    </DndContext>
  );

  function handleAddColumn() {
    const id = crypto.randomUUID();

    setItems([
      ...items,
      {
        id: id,
        identifier: "",
      },
    ]);
  }
}

export default SortableGrid;
