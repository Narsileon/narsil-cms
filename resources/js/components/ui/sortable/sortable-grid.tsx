import * as React from "react";
import { Button } from "@narsil-cms/components/ui/button";
import { cn } from "@narsil-cms/lib/utils";
import { createPortal } from "react-dom";
import { get, set } from "lodash";
import { useLabels } from "@narsil-cms/components/ui/labels";
import { VisuallyHidden } from "@narsil-cms/components/ui/visually-hidden";
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
  Dialog,
  DialogBody,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "@narsil-cms/components/ui/dialog";
import {
  FormInputRenderer,
  FormItem,
  FormLabel,
} from "@narsil-cms/components/ui/form";
import {
  SortableAdd,
  SortableItem,
  SortableListContext,
} from "@narsil-cms/components/ui/sortable";
import type { AnonymousItem } from ".";
import type { Field, GroupedSelectOption } from "@narsil-cms/types/forms";

type SortableGridProps = {
  columns?: 1 | 2 | 3 | 4;
  form?: Field[];
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
  const { getLabel } = useLabels();

  const sensors = useSensors(
    useSensor(MouseSensor),
    useSensor(TouchSensor),
    useSensor(KeyboardSensor),
  );

  const [active, setActive] = React.useState<AnonymousItem | null>(null);
  const [data, setData] = React.useState<Record<string, any>>({});
  const [open, onOpenChange] = React.useState<boolean>(false);

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

    return label;
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
            const children = get(item, intermediate.relation.handle, []);

            return (
              <SortableItem
                id={item.id}
                form={form}
                item={item}
                label={getFormattedLabel(item)}
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
          <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogTrigger asChild={true}>
              <SortableItem
                id={PLACEHOLDER_ID}
                placeholder={true}
                item={{ id: PLACEHOLDER_ID, identifier: PLACEHOLDER_ID }}
                onClick={() => onOpenChange(true)}
              >
                {placeholder}
              </SortableItem>
            </DialogTrigger>
            {form ? (
              <DialogContent>
                <DialogHeader className="border-b">
                  <DialogTitle>{intermediate.label}</DialogTitle>
                </DialogHeader>
                <DialogBody>
                  <VisuallyHidden>
                    <DialogDescription></DialogDescription>
                  </VisuallyHidden>
                  {form.map((field, index) => {
                    return (
                      <FormItem key={index}>
                        <FormLabel required={true}>{field.name}</FormLabel>
                        <FormInputRenderer
                          element={field}
                          value={data[field.handle]}
                          setValue={(value) => {
                            const nextData = { ...data };

                            set(nextData, field.handle, value);

                            setData(nextData);
                          }}
                        />
                      </FormItem>
                    );
                  })}
                </DialogBody>
                <DialogFooter className="border-t">
                  <Button
                    variant="ghost"
                    onClick={() => {
                      setData({});

                      onOpenChange(false);
                    }}
                  >
                    {getLabel("ui.cancel")}
                  </Button>
                  <Button
                    onClick={() => {
                      setItems([
                        ...items,
                        {
                          ...(data as AnonymousItem),
                          id: crypto.randomUUID(),
                        },
                      ]);

                      onOpenChange(false);
                    }}
                  >
                    {getLabel("ui.save")}
                  </Button>
                </DialogFooter>
              </DialogContent>
            ) : null}
          </Dialog>
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
