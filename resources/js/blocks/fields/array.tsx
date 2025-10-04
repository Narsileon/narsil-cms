import {
  closestCenter,
  DragOverlay,
  DndContext,
  KeyboardSensor,
  MouseSensor,
  TouchSensor,
  useSensor,
  useSensors,
  type DragCancelEvent,
  type DragEndEvent,
  type DragStartEvent,
} from "@dnd-kit/core";
import {
  arrayMove,
  SortableContext,
  useSortable,
  verticalListSortingStrategy,
} from "@dnd-kit/sortable";
import { CSS } from "@dnd-kit/utilities";
import { uniqueId } from "lodash";
import { useState } from "react";
import { createPortal } from "react-dom";

import { Button } from "@narsil-cms/blocks";
import { CardContent, CardHeader, CardRoot } from "@narsil-cms/components/card";
import {
  CollapsibleContent,
  CollapsibleRoot,
  CollapsibleTrigger,
} from "@narsil-cms/components/collapsible";
import { FormRenderer } from "@narsil-cms/components/form";
import { useLocalization } from "@narsil-cms/components/localization";
import { SortableHandle } from "@narsil-cms/components/sortable";
import { cn } from "@narsil-cms/lib/utils";
import type { Block, Field } from "@narsil-cms/types";

type Arrayitem = Record<string, string> & {
  id: string | number;
};

type ArrayProps = {
  id: string;
  form: (Block | Field)[];
  items: Arrayitem[];
  labelKey: string;
  setItems: (items: Arrayitem[]) => void;
};

function Array({ form, id, items, labelKey, setItems }: ArrayProps) {
  const { trans } = useLocalization();

  const [active, setActive] = useState<Arrayitem | null>(null);

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
      const activeIndex = items.findIndex((item) => item.id === active.id);
      const overIndex = items.findIndex((item) => item.id === over.id);

      if (activeIndex !== overIndex) {
        setItems(arrayMove(items, activeIndex, overIndex));
      }
    }

    setActive(null);
  }

  function onDragStart({ active }: DragStartEvent) {
    const item = items.find((item) => item.id === active.id) as Arrayitem;
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
          items={items.map((item) => item.id)}
          strategy={verticalListSortingStrategy}
        >
          <ul className="grid gap-4">
            {items.map((item, index) => (
              <SortableItem
                form={form}
                handle={id}
                id={item.id}
                index={index}
                item={item}
                labelKey={labelKey}
                onItemRemove={() => {
                  setItems(items.filter((x) => x.id !== item.id));
                }}
                key={item.id}
              />
            ))}
          </ul>
        </SortableContext>
        {createPortal(
          <DragOverlay>
            {active ? (
              <SortableItem id={active.id} item={active} labelKey={labelKey} />
            ) : null}
          </DragOverlay>,
          document.body,
        )}
      </DndContext>
      <Button
        className="mt-4"
        onClick={() =>
          setItems([...items, { id: uniqueId("value"), [labelKey]: "" }])
        }
      >
        {trans("ui.add")}
      </Button>
    </div>
  );
}

export default Array;

type SortableitemProps = {
  handle?: string;
  id: string | number;
  index?: number;
  item: Arrayitem;
  labelKey: string;
  form?: (Block | Field)[];
  onItemChange?: (value: Arrayitem) => void;
  onItemRemove?: () => void;
};

function SortableItem({
  handle,
  index,
  item,
  form,
  id,
  labelKey,
  onItemRemove,
}: SortableitemProps) {
  const { trans } = useLocalization();

  const [open, setCollapsed] = useState<boolean>(true);

  const {
    attributes,
    isDragging,
    listeners,
    transform,
    transition,
    setActivatorNodeRef,
    setNodeRef,
  } = useSortable({
    id: id,
  });

  return (
    <CollapsibleRoot
      ref={setNodeRef}
      className={cn(isDragging && "opacity-50")}
      open={open}
      style={{
        transform: CSS.Transform.toString(transform),
        transition: transition,
      }}
    >
      <CardRoot>
        <CollapsibleTrigger className={cn(open && "border-b")} asChild={true}>
          <CardHeader className="flex min-h-9 items-center justify-between gap-2 !py-0 pl-0 pr-1">
            <SortableHandle
              ref={setActivatorNodeRef}
              {...attributes}
              {...listeners}
            />
            <span className="grow text-start">{item[labelKey] ?? "item"}</span>
            <div className="flex items-center gap-1">
              {onItemRemove ? (
                <Button
                  className="size-7"
                  icon="trash"
                  size="icon"
                  tooltip={trans("ui.remove")}
                  variant="ghost"
                  onClick={onItemRemove}
                />
              ) : null}
              <Button
                className="size-7"
                iconProps={{
                  className: cn("duration-300", open && "rotate-180"),
                  name: "chevron-down",
                }}
                size="icon"
                variant="ghost"
                onClick={() => setCollapsed(!open)}
              />
            </div>
          </CardHeader>
        </CollapsibleTrigger>
        {form ? (
          <CollapsibleContent>
            <CardContent className="grow">
              {form?.map((item) => {
                const finalHandle = `${handle}.${index}.${item.handle}`;

                return (
                  <FormRenderer
                    {...item}
                    handle={finalHandle}
                    key={item.handle}
                  />
                );
              })}
            </CardContent>
          </CollapsibleContent>
        ) : null}
      </CardRoot>
    </CollapsibleRoot>
  );
}
