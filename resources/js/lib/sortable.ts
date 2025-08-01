import { arrayMove } from "@dnd-kit/sortable";
import { FlatNode, NestedNode } from "@narsil-cms/components/ui/sortable";
import { UniqueIdentifier } from "@dnd-kit/core";

export function flatNestedTree(
  items: NestedNode[],
  parent_id: UniqueIdentifier | null = null,
  depth: number = 0,
): FlatNode[] {
  return items.flatMap((item, index) => [
    { ...item, depth: depth, index: index, parent_id: parent_id },
    ...flatNestedTree(item.children, item.id, depth + 1),
  ]);
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

function getDragDepth(offset: number, indentationWidth: number) {
  return Math.round(offset / indentationWidth);
}

function getMaxDepth(previousItem: FlatNode) {
  if (previousItem) {
    return previousItem.depth + 1;
  }

  return 0;
}

function getMinDepth(nextItem: FlatNode) {
  if (nextItem) {
    return nextItem.depth;
  }

  return 0;
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
