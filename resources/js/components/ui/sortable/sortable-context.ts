import { createContext, useContext } from "react";
import { SortableStoreType } from "@narsil-cms/stores/sortable-store";

export const SortableContext = createContext({} as SortableStoreType);

function useSortable() {
  const context = useContext(SortableContext);

  if (!context) {
    throw new Error("useSortable must be used within a SortableProvider.");
  }

  return context;
}

export default useSortable;
