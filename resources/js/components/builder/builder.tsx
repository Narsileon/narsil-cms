import {
  closestCenter,
  DndContext,
  DragOverlay,
  MouseSensor,
  TouchSensor,
  KeyboardSensor,
  useSensor,
  useSensors,
  type DragCancelEvent,
  type DragEndEvent,
  type DragStartEvent,
} from "@dnd-kit/core";
import {
  arrayMove,
  SortableContext,
  verticalListSortingStrategy,
} from "@dnd-kit/sortable";
import { get } from "lodash";
import { Fragment, useState } from "react";

import { useForm } from "@narsil-cms/components/form";
import type { Block } from "@narsil-cms/types";

import { type BuilderNode } from ".";
import BuilderAdd from "./builder-add";
import BuilderItem from "./builder-item";

type BuilderProps = {
  name: string;
  sets: Block[];
};

function Builder({ name, sets }: BuilderProps) {
  const { data, setData } = useForm();

  const nodes = get(data, name, []) as BuilderNode[];

  function setNodes(nodes: BuilderNode[]) {
    setData?.(name, nodes);
  }

  const [active, setActive] = useState<BuilderNode | null>(null);

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
      const activeIndex = nodes.findIndex((node) => node.id == active.id);
      const overIndex = nodes.findIndex((node) => node.id == over.id);

      if (activeIndex !== overIndex) {
        setNodes(arrayMove(nodes, activeIndex, overIndex));
      }
    }
  }

  function onDragStart({ active }: DragStartEvent) {
    const node = nodes.find((node) => node.id == active.id);

    if (node) {
      setActive(node);
    }
  }

  return (
    <DndContext
      sensors={sensors}
      collisionDetection={closestCenter}
      onDragCancel={onDragCancel}
      onDragEnd={onDragEnd}
      onDragStart={onDragStart}
    >
      <SortableContext items={nodes} strategy={verticalListSortingStrategy}>
        <div className="col-span-full flex flex-col items-center justify-center">
          <div className="size-4 rounded-full bg-constructive" />
          {nodes.map((node, index) => {
            const baseHandle = `${name}.${index}`;

            return (
              <Fragment key={node.id}>
                <BuilderAdd
                  sets={sets}
                  onAdd={(node) => {
                    const newNodes = [...nodes];

                    newNodes.splice(index, 0, node);

                    setNodes(newNodes);
                  }}
                />
                <BuilderItem baseHandle={baseHandle} id={node.id} node={node} />
              </Fragment>
            );
          })}
          <BuilderAdd
            sets={sets}
            onAdd={(node) => setNodes([...nodes, node])}
          />
          <div className="size-4 rounded-full bg-destructive" />
        </div>
      </SortableContext>
      <DragOverlay>
        {active ? (
          <BuilderItem collapsed={true} id={active.id} node={active} />
        ) : null}
      </DragOverlay>
    </DndContext>
  );
}

export default Builder;
