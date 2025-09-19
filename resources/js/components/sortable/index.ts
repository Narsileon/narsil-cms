import { type UniqueIdentifier } from "@dnd-kit/core";

import SortableAdd from "./sortable-add";
import SortableGrid from "./sortable-grid";
import SortableHandle from "./sortable-handle";
import SortableItem from "./sortable-item";
import SortableItemForm from "./sortable-item-form";
import SortableList from "./sortable-list";
import SortableListContext from "./sortable-list-context";
import SortableTree from "./sortable-tree";
import SortableTable from "./table/sortable-table";
import SortableTableRow from "./table/sortable-table-row";

type AnonymousItem = Record<string, unknown> & {
  id: UniqueIdentifier;
  identifier: string;
};

type FlatNode = {
  data?: Record<string, unknown>;
  depth: number;
  id: UniqueIdentifier;
  parent_id: UniqueIdentifier | null;
  type: string;
};

type NestedNode = {
  children: NestedNode[];
  data?: Record<string, unknown>;
  id: UniqueIdentifier;
  type: string;
};

export {
  SortableAdd,
  SortableGrid,
  SortableHandle,
  SortableItem,
  SortableItemForm,
  SortableList,
  SortableListContext,
  SortableTable,
  SortableTableRow,
  SortableTree,
};

export type { AnonymousItem, FlatNode, NestedNode };
