import { type UniqueIdentifier } from "@dnd-kit/core";
import SortableAdd from "./sortable-add";
import SortableGrid from "./sortable-grid";
import SortableHandle from "./sortable-handle";
import SortableItem from "./sortable-item";
import SortableItemForm from "./sortable-item-form";
import SortableList from "./sortable-list";
import SortableListContext from "./sortable-list-context";

type AnonymousItem = Record<string, unknown> & {
  id: UniqueIdentifier;
  identifier: string;
};

export {
  SortableAdd,
  SortableGrid,
  SortableHandle,
  SortableItem,
  SortableItemForm,
  SortableList,
  SortableListContext,
};

export type { AnonymousItem };
