import { type UniqueIdentifier } from "@dnd-kit/core";
import SortableAdd from "./sortable-add";
import SortableGrid from "./sortable-grid";
import SortableItem from "./sortable-item";
import SortableItemForm from "./sortable-item-form";
import SortableItemMenu from "./sortable-item-menu";
import SortableList from "./sortable-list";
import SortableListContext from "./sortable-list-context";

type AnonymousItem = Record<string, unknown> & {
  id: UniqueIdentifier;
  identifier: string;
};

export {
  SortableAdd,
  SortableGrid,
  SortableItem,
  SortableItemForm,
  SortableItemMenu,
  SortableList,
  SortableListContext,
};

export type { AnonymousItem };
