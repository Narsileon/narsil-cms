import Tree from "./tree";
import TreeItem from "./tree-item";
import TreeItemMenu from "./tree-item-menu";

type FlatNode = {
  badge?: string;
  children: NestedNode[];
  collapsed?: boolean;
  data?: Record<string, unknown>;
  depth: number;
  id: number | string;
  label: string;
  left_id: number | string | null;
  parent_id: number | string | null;
  right_id: number | string | null;
  type?: string;
  [key: string]: unknown;
};

type NestedNode = {
  badge?: string;
  children: NestedNode[];
  data?: Record<string, unknown>;
  id: number | string;
  label: string;
  type?: string;
};

export { Tree, TreeItem, TreeItemMenu };

export type { FlatNode, NestedNode };
