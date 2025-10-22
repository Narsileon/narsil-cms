import { UniqueIdentifier } from "@dnd-kit/core";
import { arrayMove } from "@dnd-kit/sortable";
import { type FlatNode, type NestedNode } from "@narsil-cms/blocks/fields/tree";

export function buildTree(flattenedItems: FlatNode[]): NestedNode[] {
  const root: NestedNode = { id: "root", children: [] };
  const nodes: Record<string, NestedNode> = { [root.id]: root };
  const items = flattenedItems.map((item) => ({ ...item, children: [] }));

  for (const item of items) {
    const { id, children } = item;
    const parentId = item.parent_id ?? root.id;
    const parent = nodes[parentId] ?? findTreeNode(items, parentId);

    nodes[id] = { id, children };
    parent.children.push(item);
  }

  return root.children;
}

export function findTreeNode(items: NestedNode[], itemId: UniqueIdentifier) {
  return items.find(({ id }) => id === itemId);
}

export function flatTree(
  items: NestedNode[],
  parent_id: UniqueIdentifier | null = null,
  depth: number = 0,
): FlatNode[] {
  return items.flatMap((item, index) => {
    const leftId = index > 0 ? items[index - 1].id : null;
    const rightId = index < items.length - 1 ? items[index + 1].id : null;

    const flatItem: FlatNode = {
      ...item,
      depth: depth,
      index: index,
      left_id: leftId,
      parent_id: parent_id,
      right_id: rightId,
    };

    return [flatItem, ...flatTree(item.children, item.id, depth + 1)];
  });
}

export function getDragDepth(offset: number, indentationWidth: number) {
  return Math.round(offset / indentationWidth);
}

export function getMaxDepth(previousItem: FlatNode) {
  if (previousItem) {
    return previousItem.depth + 1;
  }

  return 0;
}

export function getMinDepth(nextItem: FlatNode) {
  if (nextItem) {
    return nextItem.depth;
  }

  return 0;
}

export function getProjection(
  items: FlatNode[],
  activeId: UniqueIdentifier,
  overId: UniqueIdentifier,
  dragOffset: number,
  indentationWidth: number,
) {
  const activeItemIndex = items.findIndex(({ id }) => id === activeId);
  const overItemIndex = items.findIndex(({ id }) => id === overId);

  const newItems = arrayMove(items, activeItemIndex, overItemIndex);

  const activeItem = items[activeItemIndex];
  const previousItem = newItems[overItemIndex - 1];
  const nextItem = newItems[overItemIndex + 1];

  const dragDepth = getDragDepth(dragOffset, indentationWidth);
  const maxDepth = getMaxDepth(previousItem);
  const minDepth = getMinDepth(nextItem);

  let depth = activeItem.depth + dragDepth;

  if (depth >= maxDepth) {
    depth = maxDepth;
  } else if (depth < minDepth) {
    depth = minDepth;
  }

  function getParentId() {
    if (depth === 0 || !previousItem) {
      return null;
    }

    if (depth === previousItem.depth) {
      return previousItem.parent_id;
    }

    if (depth > previousItem.depth) {
      return previousItem.id;
    }

    const newParent = newItems
      .slice(0, overItemIndex)
      .reverse()
      .find((item) => item.depth === depth)?.parent_id;

    return newParent ?? null;
  }

  return { depth, maxDepth, minDepth, parentId: getParentId() };
}

export function removeChildren(items: FlatNode[], ids: UniqueIdentifier[]) {
  const excludeParentIds = [...ids];

  return items.filter((item) => {
    if (item.parent_id && excludeParentIds.includes(item.parent_id)) {
      if (item.children.length) {
        excludeParentIds.push(item.id);
      }

      return false;
    }

    return true;
  });
}

export function setProperty<T extends keyof NestedNode>(
  items: NestedNode[],
  id: UniqueIdentifier,
  property: T,
  setter: (value: NestedNode[T]) => NestedNode[T],
) {
  for (const item of items) {
    if (item.id === id) {
      item[property] = setter(item[property]);

      continue;
    }

    if (item.children?.length) {
      item.children = setProperty(item.children, id, property, setter);
    }
  }

  return [...items];
}
