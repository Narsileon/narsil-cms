import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { createPortal } from "react-dom";
import { get } from "lodash";
import {
  DndContext,
  DragOverlay,
  KeyboardSensor,
  MouseSensor,
  TouchSensor,
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
} from ".";
import type { AnonymousItem } from ".";
import type {
  CancelDrop,
  DragCancelEvent,
  DragEndEvent,
  DragOverEvent,
  DragStartEvent,
  UniqueIdentifier,
} from "@dnd-kit/core";
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

  function onDragCancel({}: DragCancelEvent) {
    setActive(null);
  }

  function onDragStart({ active }: DragStartEvent) {
    const activeContainer = items.find(
      (container) => getContainerIdentifier(container) === active.id,
    );

    if (activeContainer) {
      setActive(activeContainer);
    } else {
      items.map((container) => {
        const children = getContainerChildren(container);

        children.map((child) => {
          if (getChildIdentifier(child) === active.id) {
            setActive(child);

            return;
          }
        });
      });
    }
  }

  function onDragEnd({ active, over }: DragEndEvent) {
    setActive(null);

    if (!over) {
      return;
    }

    if (moveContainer(active.id, over.id)) {
      return;
    }

    if (moveChild(active.id, over.id, false)) {
      return;
    }
  }

  function onDragOver({ active, over }: DragOverEvent) {
    if (!over) {
      return;
    }

    moveChild(active.id, over.id, true);
  }

  function getChildGroup(child: AnonymousItem) {
    const group = intermediate.relation.settings.options?.find((option) =>
      child.identifier.includes(option.identifier),
    ) as GroupedSelectOption;

    return group;
  }

  function getChildIdentifier(child: AnonymousItem) {
    const group = getChildGroup(child);

    return child[group.optionValue];
  }

  function getContainerChildren(container: AnonymousItem) {
    const children: AnonymousItem[] = get(
      container,
      intermediate.relation.handle,
      [],
    );

    return children;
  }

  function getContainerIdentifier(container: AnonymousItem) {
    return get(container, "handle", container.id);
  }

  function getFormattedLabel(container: AnonymousItem) {
    const label = container[intermediate.optionLabel];
    const value = container[intermediate.optionValue];

    return `${label} (${value})`;
  }

  function moveChild(
    activeChildIdentifier: UniqueIdentifier,
    overIdentifier: UniqueIdentifier,
    across: boolean = false,
  ): boolean {
    if (activeChildIdentifier === overIdentifier) {
      return false;
    }

    let activeChild: AnonymousItem | undefined = undefined;
    let activeChildIndex: number | undefined = undefined;
    let activeContainer: AnonymousItem | undefined = undefined;
    let activeContainerIndex: number | undefined = undefined;
    let activeContainerIdentifier: UniqueIdentifier | undefined = undefined;

    let overChildIndex: number | undefined = undefined;
    let overContainer: AnonymousItem | undefined = undefined;
    let overContainerIndex: number | undefined = undefined;
    let overContainerIdentifier: UniqueIdentifier | undefined = undefined;

    items.forEach((container, containerIndex) => {
      const containerIdentifier = getContainerIdentifier(container);

      if (containerIdentifier === overIdentifier) {
        overContainer = container;
        overContainerIndex = containerIndex;
        overContainerIdentifier = containerIdentifier;
      }

      const children = getContainerChildren(container);

      children.forEach((child, childIndex) => {
        const childIdentifier = getChildIdentifier(child);

        if (childIdentifier === activeChildIdentifier) {
          activeChild = child;
          activeChildIndex = childIndex;
          activeContainer = container;
          activeContainerIndex = containerIndex;
          activeContainerIdentifier = containerIdentifier;
        }
        if (childIdentifier === overIdentifier) {
          overChildIndex = childIndex;
          overContainer = container;
          overContainerIndex = containerIndex;
          overContainerIdentifier = containerIdentifier;
        }
      });
    });

    if (across && activeContainerIdentifier === overContainerIdentifier) {
      return false;
    }

    if (
      activeContainer === undefined ||
      activeContainerIndex === undefined ||
      activeChildIndex === undefined ||
      overContainer === undefined ||
      overContainerIndex === undefined
    ) {
      return false;
    }

    const nextItems = [...items];

    if (across) {
      const activeChildren = getContainerChildren(activeContainer);
      const overChildren = getContainerChildren(overContainer);

      const newActiveChildren = activeChildren.filter(
        (child, index) => index !== activeChildIndex,
      );

      const insertIndex = overChildIndex ?? overChildren.length;

      const newOverChildren = [
        ...overChildren.slice(0, insertIndex),
        activeChild,
        ...overChildren.slice(insertIndex),
      ];

      nextItems[activeContainerIndex] = {
        ...nextItems[activeContainerIndex],
        [intermediate.relation.handle]: newActiveChildren,
      };

      nextItems[overContainerIndex] = {
        ...nextItems[overContainerIndex],
        [intermediate.relation.handle]: newOverChildren,
      };
    } else {
      if (activeContainerIdentifier !== overContainerIdentifier) {
        return false;
      }
      if (activeChildIndex === overChildIndex) {
        return false;
      }

      const updatedChildren = arrayMove(
        getContainerChildren(activeContainer),
        activeChildIndex,
        overChildIndex ?? activeChildIndex,
      );

      nextItems[activeContainerIndex] = {
        ...nextItems[activeContainerIndex],
        [intermediate.relation.handle]: updatedChildren,
      };
    }

    setItems(nextItems);

    return true;
  }

  function moveContainer(
    activeIdentifier: UniqueIdentifier,
    overIdentifier: UniqueIdentifier,
  ): boolean {
    if (activeIdentifier === overIdentifier) {
      return false;
    }

    let activeIndex: number | undefined = undefined;
    let overIndex: number | undefined = undefined;

    items.forEach((container, index) => {
      const identifier = getContainerIdentifier(container);

      if (identifier === activeIdentifier) {
        activeIndex = index;
      }
      if (identifier === overIdentifier) {
        overIndex = index;
      }
    });

    if (activeIndex === undefined || overIndex === undefined) {
      return false;
    }

    const nextItems = arrayMove(items, activeIndex, overIndex);

    setItems(nextItems);

    return true;
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
          items={items.map((container) => getContainerIdentifier(container))}
          strategy={rectSortingStrategy}
        >
          {items.map((container) => {
            const identifier = getContainerIdentifier(container);
            const children = getContainerChildren(container);

            return (
              <SortableItem
                id={identifier}
                form={form}
                item={container}
                label={getFormattedLabel(container)}
                optionValue={intermediate.optionValue}
                onItemChange={(value: AnonymousItem) => {
                  setItems(
                    items.map((container) =>
                      getContainerIdentifier(container) === identifier
                        ? value
                        : container,
                    ),
                  );
                }}
                onItemRemove={() => {
                  setItems(items.filter((item) => item !== container));
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
                              const updatedItems = items.map((container) =>
                                getContainerIdentifier(container) === identifier
                                  ? {
                                      ...container,
                                      [intermediate.relation.handle]:
                                        groupItems,
                                    }
                                  : container,
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
                key={identifier}
              >
                <SortableListContext
                  {...intermediate.relation.settings}
                  items={children}
                  options={
                    intermediate.relation.settings
                      .options as GroupedSelectOption[]
                  }
                  setItems={(groupItems) => {
                    const updatedItems = items.map((container) =>
                      getContainerIdentifier(container) === identifier
                        ? {
                            ...container,
                            [intermediate.relation.handle]: groupItems,
                          }
                        : container,
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
              ids={items.map((container) => getContainerIdentifier(container))}
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
            items.some(
              (container) =>
                getContainerIdentifier(container) ===
                getContainerIdentifier(active),
            ) ? (
              <SortableItem
                id={getContainerIdentifier(active)}
                item={active}
                label={getFormattedLabel(active)}
              />
            ) : (
              <SortableItem
                id={getContainerIdentifier(active)}
                item={active}
                label={getFormattedLabel(active)}
              />
            )
          ) : null}
        </DragOverlay>,
        document.body,
      )}
    </DndContext>
  );
}

export default SortableGrid;
