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
import { BackgroundRoot } from "@narsil-cms/components/background";
import BackgroundGrid from "@narsil-cms/components/background/background-grid";
import { useForm } from "@narsil-cms/components/form";
import type { Block } from "@narsil-cms/types";
import { get } from "lodash";
import { Fragment, useState } from "react";
import { type BuilderElement } from ".";
import BuilderAdd from "./builder-add";
import BuilderItem from "./builder-item";

type BuilderProps = {
  blocks: Block[];
  name: string;
};

function Builder({ blocks, name }: BuilderProps) {
  const { data, setData } = useForm();

  const items = get(data, name, []) as BuilderElement[];

  function setItems(items: BuilderElement[]) {
    setData?.(name, items);
  }

  const [active, setActive] = useState<BuilderElement | null>(null);

  const sensors = useSensors(
    useSensor(MouseSensor),
    useSensor(TouchSensor),
    useSensor(KeyboardSensor),
  );

  function onDragCancel({}: DragCancelEvent) {
    setActive(null);
  }

  function onDragEnd({ active, over }: DragEndEvent) {
    setActive(null);

    if (over) {
      const activeIndex = items.findIndex((item) => item.uuid == active.id);
      const overIndex = items.findIndex((item) => item.uuid == over.id);

      if (activeIndex !== overIndex) {
        setItems(arrayMove(items, activeIndex, overIndex));
      }
    }
  }

  function onDragStart({ active }: DragStartEvent) {
    const item = items.find((item) => item.uuid == active.id);

    if (item) {
      setActive(item);
    }
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
    <DndContext
      sensors={sensors}
      collisionDetection={closestCenter}
      onDragCancel={onDragCancel}
      onDragEnd={onDragEnd}
      onDragStart={onDragStart}
    >
      <SortableContext
        items={items.map((item) => item.uuid)}
        strategy={verticalListSortingStrategy}
      >
        <div className="relative col-span-full flex flex-col items-center justify-center rounded p-4">
          <BackgroundRoot>
            <BackgroundGrid id={name} />
          </BackgroundRoot>
          <div className="size-4 rounded-full bg-constructive" />
          {items.map((item, index) => {
            const baseHandle = `${name}.${index}`;

            return (
              <Fragment key={item.uuid}>
                <BuilderAdd
                  blocks={blocks}
                  separatorClassName="border-constructive"
                  onAdd={(item) => {
                    const newItems = [...items];

                    newItems.splice(index, 0, item);

                    setItems(newItems);
                  }}
                />
                <BuilderItem
                  baseHandle={baseHandle}
                  id={item.uuid}
                  item={item}
                  onMoveDown={index < items.length - 1 ? () => onMoveDown(item.uuid) : undefined}
                  onMoveUp={index !== 0 ? () => onMoveUp(item.uuid) : undefined}
                  onRemove={() => onRemove(item.uuid)}
                />
              </Fragment>
            );
          })}
          <BuilderAdd
            blocks={blocks}
            separatorClassName="border-destructive"
            onAdd={(item) => setItems([...items, item])}
          />
          <div className="size-4 rounded-full bg-destructive" />
        </div>
      </SortableContext>
      <DragOverlay>
        {active ? <BuilderItem collapsed={true} id={active.uuid} item={active} /> : null}
      </DragOverlay>
    </DndContext>
  );
}

export default Builder;
