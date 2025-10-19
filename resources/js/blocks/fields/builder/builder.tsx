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
import { useForm } from "@narsil-cms/components/form";
import type { Block } from "@narsil-cms/types";
import { get } from "lodash";
import { Fragment, useState } from "react";
import { type BuilderElement } from ".";
import BuilderAdd from "./builder-add";
import BuilderItem from "./builder-item";

type BuilderProps = {
  name: string;
  sets: Block[];
};

function Builder({ name, sets }: BuilderProps) {
  const { data, setData } = useForm();

  const nodes = get(data, name, []) as BuilderElement[];

  function setNodes(nodes: BuilderElement[]) {
    setData?.(name, nodes);
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
      const activeIndex = nodes.findIndex((node) => node.uuid == active.id);
      const overIndex = nodes.findIndex((node) => node.uuid == over.id);

      if (activeIndex !== overIndex) {
        setNodes(arrayMove(nodes, activeIndex, overIndex));
      }
    }
  }

  function onDragStart({ active }: DragStartEvent) {
    const node = nodes.find((node) => node.uuid == active.id);

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
      <SortableContext
        items={nodes.map((node) => node.uuid)}
        strategy={verticalListSortingStrategy}
      >
        <div className="col-span-full flex flex-col items-center justify-center">
          <div className="bg-constructive size-4 rounded-full" />
          {nodes.map((node, index) => {
            const baseHandle = `${name}.${index}`;

            return (
              <Fragment key={node.uuid}>
                <BuilderAdd
                  sets={sets}
                  onAdd={(node) => {
                    const newNodes = [...nodes];

                    newNodes.splice(index, 0, node);

                    setNodes(newNodes);
                  }}
                />
                <BuilderItem baseHandle={baseHandle} id={node.uuid} node={node} />
              </Fragment>
            );
          })}
          <BuilderAdd sets={sets} onAdd={(node) => setNodes([...nodes, node])} />
          <div className="bg-destructive size-4 rounded-full" />
        </div>
      </SortableContext>
      <DragOverlay>
        {active ? <BuilderItem collapsed={true} id={active.uuid} node={active} /> : null}
      </DragOverlay>
    </DndContext>
  );
}

export default Builder;
