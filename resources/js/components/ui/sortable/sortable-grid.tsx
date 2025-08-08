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
  SortableItemForm,
  SortableListContext,
  type AnonymousItem,
} from ".";
import type {
  Field,
  FormType,
  GroupedSelectOption,
} from "@narsil-cms/types/forms";

type SortableGridProps = {
  columns?: 1 | 2 | 3 | 4;
  form?: FormType;
  items: AnonymousItem[];
  placeholder: string;
  intermediate: {
    label: string;
    optionLabel: string;
    optionValue: string;
    relation: Field;
  };
  setItems: (items: AnonymousItem[]) => void;
  cancelDrop?: CancelDrop;
};

const PLACEHOLDER_ID = "placeholder";

function SortableGrid({
  columns = 2,
  form,
  items,
  placeholder,
  intermediate,
  cancelDrop,
  setItems,
}: SortableGridProps) {
  const sensors = useSensors(
    useSensor(MouseSensor),
    useSensor(TouchSensor),
    useSensor(KeyboardSensor),
  );

  const [active, setActive] = React.useState<AnonymousItem | null>(null);

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
          [intermediate.relation.handle]: getContainerChildren(
            container,
          ).filter((child) => getChildUniqueIdentifier(child) !== active.id),
        };
      }

      if (container.id === overItem.id) {
        return {
          ...container,
          [intermediate.relation.handle]: [
            ...getContainerChildren(container),
            activeItem,
          ],
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
    const children: AnonymousItem[] = get(
      container,
      intermediate.relation.handle,
      [],
    );

    return children;
  }

  function getChildGroup(child: AnonymousItem) {
    const group = intermediate.relation.settings.options?.find((option) =>
      child.identifier.includes(option.identifier),
    ) as GroupedSelectOption;

    return group;
  }

  function getChildUniqueIdentifier(child: AnonymousItem) {
    const group = getChildGroup(child);

    return child[group.optionValue];
  }

  function getFormattedLabel(container: AnonymousItem) {
    const label = container[intermediate.optionLabel];
    const value = container[intermediate.optionValue];

    return `${label} (${value})`;
  }

  const ids = items.map((item) => get(item, intermediate.optionValue));

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
        <SortableContext items={ids} strategy={rectSortingStrategy}>
          {items.map((item) => {
            const children = get(item, intermediate.relation.handle, []);

            return (
              <SortableItem
                id={item.id}
                form={form}
                item={item}
                label={getFormattedLabel(item)}
                optionValue={intermediate.optionValue}
                onItemChange={(value: AnonymousItem) => {
                  setItems(items.map((x) => (x.id === item.id ? value : x)));
                }}
                onItemRemove={() => {
                  setItems(items.filter((x) => x !== item));
                }}
                footer={
                  <>
                    {intermediate.relation.settings.options?.map(
                      (group, index) => {
                        return (
                          <SortableAdd
                            ids={items
                              .flatMap(
                                (item) =>
                                  item[intermediate.relation.handle] || [],
                              )
                              .map((x) => x.handle)}
                            items={children}
                            group={group as GroupedSelectOption}
                            setItems={(groupItems) => {
                              const updatedItems = items.map((x) =>
                                x.id === item.id
                                  ? {
                                      ...x,
                                      [intermediate.relation.handle]:
                                        groupItems,
                                    }
                                  : x,
                              );
                              setItems(updatedItems);
                            }}
                            key={index}
                          />
                        );
                      },
                    )}
                  </>
                }
                key={item.id}
              >
                <SortableListContext
                  items={children}
                  options={
                    intermediate.relation.settings
                      .options as GroupedSelectOption[]
                  }
                  setItems={(groupItems) => {
                    const updatedItems = items.map((x) =>
                      x.id === item.id
                        ? {
                            ...x,
                            [intermediate.relation.handle]: groupItems,
                          }
                        : x,
                    );
                    setItems(updatedItems);
                  }}
                />
              </SortableItem>
            );
          })}
          {form ? (
            <SortableItemForm
              form={form}
              ids={ids}
              optionValue={intermediate.optionValue}
              onItemChange={(data) =>
                setItems([
                  ...items,
                  {
                    ...(data as AnonymousItem),
                    id: crypto.randomUUID(),
                  },
                ])
              }
            >
              <SortableItem
                id={PLACEHOLDER_ID}
                placeholder={true}
                item={{ id: PLACEHOLDER_ID, identifier: PLACEHOLDER_ID }}
              >
                {placeholder}
              </SortableItem>
            </SortableItemForm>
          ) : null}
        </SortableContext>
      </div>
      {createPortal(
        <DragOverlay>
          {active ? (
            items.some((x) => x.id === active.id) ? (
              <SortableItem
                id={active.id}
                item={active}
                label={getFormattedLabel(active)}
              />
            ) : (
              <SortableItem id={active.id} item={active} label={active.name} />
            )
          ) : null}
        </DragOverlay>,
        document.body,
      )}
    </DndContext>
  );
}

export default SortableGrid;
