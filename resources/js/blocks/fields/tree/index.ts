import Tree from "./tree";
import TreeItem from "./tree-item";
import TreeItemMenu from "./tree-item-menu";

type FlatNode = {
  children: NestedNode[];
  collapsed?: boolean;
  data?: Record<string, unknown>;
  depth: number;
  id: number | string;
  parent_id: number | string | null;
  type?: string;
  [key: string]: unknown;
};

type NestedNode = {
  children: NestedNode[];
  data?: Record<string, unknown>;
  id: number | string;
  type?: string;
};

export { Tree, TreeItem, TreeItemMenu };

export type { FlatNode, NestedNode };
