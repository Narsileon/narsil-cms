import Tree from "./tree";

type FlatNode = {
  children: NestedNode[];
  collapsed?: boolean;
  data?: Record<string, unknown>;
  depth: number;
  id: number | string;
  parent_id: number | string | null;
  type?: string;
};

type NestedNode = {
  children: NestedNode[];
  data?: Record<string, unknown>;
  id: number | string;
  type?: string;
};

export { Tree };

export type { FlatNode, NestedNode };
