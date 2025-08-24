import * as React from "react";
import { useState } from "react";
import BuilderAdd from "./builder-add";
import BuilderItem from "./builder-item";
import BuilderSeparator from "./builder-seperator";
import {
  closestCenter,
  DndContext,
  DragOverlay,
  MouseSensor,
  TouchSensor,
  KeyboardSensor,
  useSensor,
  useSensors,
} from "@dnd-kit/core";
import {
  arrayMove,
  SortableContext,
  verticalListSortingStrategy,
} from "@dnd-kit/sortable";
import type { Block } from "@narsil-cms/types/forms";
import type { BuilderNode } from ".";
import type {
  DragCancelEvent,
  DragEndEvent,
  DragStartEvent,
} from "@dnd-kit/core";

type BuilderProps = {
  blocks: Block[];
  nodes: BuilderNode[];
  name: string;
  setNodes: (items: BuilderNode[]) => void;
};

function Builder({ blocks, name, nodes, setNodes }: BuilderProps) {
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
        <div className="flex flex-col items-center justify-center">
          <div className="bg-constructive size-4 rounded-full" />
          <BuilderSeparator />
          {nodes.map((node, index) => {
            const baseHandle = `${name}.${index}`;

            return (
              <React.Fragment key={node.id}>
                <BuilderAdd
                  blocks={blocks}
                  onAdd={(node) => {
                    const newNodes = [...nodes];

                    newNodes.splice(index, 0, node);

                    setNodes(newNodes);
                  }}
                />
                <BuilderSeparator />
                <BuilderItem baseHandle={baseHandle} id={node.id} node={node} />
                <BuilderSeparator />
              </React.Fragment>
            );
          })}
          <BuilderAdd
            blocks={blocks}
            onAdd={(node) => setNodes([...nodes, node])}
          />
          <BuilderSeparator />
          <div className="bg-destructive size-4 rounded-full" />
        </div>
      </SortableContext>
      <DragOverlay>
        {active ? <BuilderItem id={active.id} node={active} /> : null}
      </DragOverlay>
    </DndContext>
  );
}

export default Builder;
