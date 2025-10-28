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
  type DragMoveEvent,
  type DragOverEvent,
  type DragStartEvent,
  type UniqueIdentifier,
} from "@dnd-kit/core";
import { arrayMove, SortableContext, verticalListSortingStrategy } from "@dnd-kit/sortable";
import { buildTree, flatTree, getProjection, removeChildren } from "@narsil-cms/lib/dnd-tree";
import { useEffect, useMemo, useRef, useState } from "react";
import { createPortal } from "react-dom";
import { NestedNode, type FlatNode } from ".";
import TreeItem from "./tree-item";

type TreeProps = {
  items: NestedNode[];
  setItems: (items: NestedNode[]) => void;
};

function Tree({ items, setItems }: TreeProps) {
  const [activeId, setActiveId] = useState<UniqueIdentifier | null>(null);
  const [overId, setOverId] = useState<UniqueIdentifier | null>(null);

  const [offsetLeft, setOffsetLeft] = useState(0);

  const flattenedItems = useMemo(() => {
    const flattenedTree = flatTree(items);

    const collapsedItems = flattenedTree.reduce<UniqueIdentifier[]>(
      (acc, { children, collapsed, id }) => (collapsed && children.length ? [...acc, id] : acc),
      [],
    );

    return removeChildren(
      flattenedTree,
      activeId != null ? [activeId, ...collapsedItems] : collapsedItems,
    );
  }, [activeId, items]);

  const sensorContext = useRef({
    items: flattenedItems,
    offset: offsetLeft,
  });

  const sensors = useSensors(
    useSensor(MouseSensor, {}),
    useSensor(TouchSensor, {}),
    useSensor(KeyboardSensor, {}),
  );

  const activeItem = activeId ? flattenedItems.find(({ id }) => id === activeId) : null;

  const projected =
    activeId && overId ? getProjection(flattenedItems, activeId, overId, offsetLeft, 20) : null;

  function handleDragCancel({}: DragCancelEvent) {
    resetState();
  }

  function handleDragEnd({ active, over }: DragEndEvent) {
    resetState();

    if (!projected || !over) {
      return;
    }

    const clonedItems: FlatNode[] = JSON.parse(JSON.stringify(flatTree(items)));

    const activeIndex = clonedItems.findIndex(({ id }) => id === active.id);
    const overIndex = clonedItems.findIndex(({ id }) => id === over.id);

    const { depth, parentId } = projected;

    const activeTreeItem = clonedItems[activeIndex];

    clonedItems[activeIndex] = {
      ...activeTreeItem,
      depth,
      parent_id: parentId,
    };

    const sortedItems = arrayMove(clonedItems, activeIndex, overIndex);
    const newItems = buildTree(sortedItems);

    setItems(newItems);
  }

  function handleDragMove({ delta }: DragMoveEvent) {
    setOffsetLeft(delta.x);
  }

  function handleDragOver({ over }: DragOverEvent) {
    setOverId(over?.id ?? null);
  }

  function handleDragStart({ active }: DragStartEvent) {
    setActiveId(active.id);
    setOverId(active.id);

    document.body.style.setProperty("cursor", "grabbing");
  }

  function handleMove(id: UniqueIdentifier, direction: "up" | "down") {
    const flatItems = flatTree(items);

    const currentIndex = flatItems.findIndex((item) => item.id === id);

    if (currentIndex === -1) {
      return;
    }

    const currentItem = flatItems[currentIndex];
    const targetId = direction === "up" ? currentItem.left_id : currentItem.right_id;

    if (!targetId) {
      return;
    }

    const targetIndex = flatItems.findIndex((item) => item.id === targetId);

    if (targetIndex === -1) {
      return;
    }

    const sortedItems = arrayMove(flatItems, currentIndex, targetIndex);
    const newItems = buildTree(sortedItems);

    setItems(newItems);
  }

  function onRemove(id: UniqueIdentifier) {
    const flatItems = flatTree(items);

    const target = flatItems.find((item) => item.id === id);

    if (!target) {
      return;
    }

    const idsToRemove = [id];

    const collectChildren = (parentId: UniqueIdentifier) => {
      flatItems.forEach((node) => {
        if (node.parent_id === parentId) {
          idsToRemove.push(node.id);
          collectChildren(node.id);
        }
      });
    };

    collectChildren(id);

    const remainingItems = flatItems.filter((item) => !idsToRemove.includes(item.id));

    const newItems = buildTree(remainingItems);

    setItems(newItems);
  }

  function resetState() {
    setActiveId(null);
    setOffsetLeft(0);
    setOverId(null);

    document.body.style.setProperty("cursor", "");
  }

  useEffect(() => {
    sensorContext.current = {
      items: flattenedItems,
      offset: offsetLeft,
    };
  }, [flattenedItems, offsetLeft]);

  return (
    <DndContext
      collisionDetection={closestCenter}
      onDragCancel={handleDragCancel}
      onDragEnd={handleDragEnd}
      onDragMove={handleDragMove}
      onDragOver={handleDragOver}
      onDragStart={handleDragStart}
      sensors={sensors}
    >
      <SortableContext items={flattenedItems} strategy={verticalListSortingStrategy}>
        <div className="grid">
          {flattenedItems.map((item) => {
            const depth = item.id === activeId && projected ? projected.depth : item.depth;

            return (
              <TreeItem
                disabled={depth === 0}
                id={item.id}
                item={item}
                label={item.id.toString()}
                style={{ marginLeft: `${depth * 16}px` }}
                onMoveDown={item.right_id ? () => handleMove(item.id, "down") : undefined}
                onMoveUp={item.left_id ? () => handleMove(item.id, "up") : undefined}
                onRemove={item.parent_id ? () => onRemove(item.id) : undefined}
                key={item.id}
              />
            );
          })}
          {createPortal(
            <DragOverlay>
              {activeId && activeItem ? <TreeItem id={activeItem.id} item={activeItem} /> : null}
            </DragOverlay>,
            document.body,
          )}
        </div>
      </SortableContext>
    </DndContext>
  );
}

export default Tree;
