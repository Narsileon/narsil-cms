import Sortable from "./sortable";
import SortableAdd from "./sortable-add";
import SortableGrid from "./sortable-grid";
import SortableHandle from "./sortable-handle";
import SortableItem from "./sortable-item";
import SortableRow from "./sortable-row";
import SortableTable from "./sortable-table";
import SortableTree from "./sortable-tree";
import type { UniqueIdentifier } from "@dnd-kit/core";

type AnonymousItem = Record<string, any> & {
  id: UniqueIdentifier;
  identifier?: UniqueIdentifier;
};

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

export {
  Sortable,
  SortableAdd,
  SortableGrid,
  SortableHandle,
  SortableItem,
  SortableRow,
  SortableTable,
  SortableTree,
};

export type { AnonymousItem, FlatNode, NestedNode };
