import type { ContentTreeNode } from "./types";

export function findTreeNode(
  tree: ContentTreeNode[],
  nodeId: string,
): ContentTreeNode | null {
  for (const node of tree) {
    if (node.id === nodeId) {
      return node;
    }

    const match = findTreeNode(node.children, nodeId);

    if (match) {
      return match;
    }
  }

  return null;
}

export function flattenTree(tree: ContentTreeNode[]): ContentTreeNode[] {
  return tree.flatMap((node) => [node, ...flattenTree(node.children)]);
}

/**
 * Apply a new sibling order locally so the tree does not snap back while the
 * server round trip is in flight.
 */
export function reorderChildren(
  tree: ContentTreeNode[],
  parentUuid: string,
  uuids: string[],
): ContentTreeNode[] {
  return tree.map((node) => {
    if (node.id !== parentUuid) {
      return {
        ...node,
        children: reorderChildren(node.children, parentUuid, uuids),
      };
    }

    const byId = new Map(node.children.map((child) => [child.id, child]));

    const children = uuids
      .map((uuid) => byId.get(uuid))
      .filter((child): child is ContentTreeNode => !!child)
      .map((child, index) => ({ ...child, position: index }));

    return { ...node, children: children };
  });
}
