import SortableTable from "./sortable-table";
import SortableTableRow from "./sortable-table-row";
import type { UniqueIdentifier } from "@dnd-kit/core";

type SortableTableItem = Record<string, any> & {
  id: UniqueIdentifier;
};

export { SortableTable, SortableTableRow };

export type { SortableTableItem };
