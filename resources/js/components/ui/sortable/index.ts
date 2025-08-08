import SortableAdd from "./sortable-add";
import SortableGrid from "./sortable-grid";
import SortableHandle from "./sortable-handle";
import SortableItem from "./sortable-item";
import SortableItemForm from "./sortable-item-form";
import SortableItemWidth from "./sortable-item-width";
import SortableList from "./sortable-list";
import SortableListContext from "./sortable-list-context";
import SortableTable from "./table/sortable-table";
import SortableTableRow from "./table/sortable-table-row";
import SortableTree from "./sortable-tree";
import type { UniqueIdentifier } from "@dnd-kit/core";

type AnonymousItem = Record<string, any> & {
  id: UniqueIdentifier;
  identifier: string;
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
  SortableAdd,
  SortableGrid,
  SortableHandle,
  SortableItem,
  SortableItemForm,
  SortableItemWidth,
  SortableList,
  SortableListContext,
  SortableTable,
  SortableTableRow,
  SortableTree,
};

export type { AnonymousItem, FlatNode, NestedNode };
