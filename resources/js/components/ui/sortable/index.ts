import Sortable from "./sortable";
import SortableItem from "./sortable-item";
import SortableProvider from "./sortable-provider";
import type { UniqueIdentifier } from "@dnd-kit/core";

type FlatNode = {
  data?: Record<string, any>;
  depth: number;
  id: UniqueIdentifier;
  parent_id: UniqueIdentifier | null;
  type: string;
};

type NestedNode = {
  children: NestedNode[];
  data?: Record<string, any>;
  id: UniqueIdentifier;
  type: string;
};

export { Sortable, SortableItem, SortableProvider };

export type { FlatNode, NestedNode };
