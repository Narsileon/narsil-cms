import { create } from "zustand";
import { type FlatNode } from "@narsil-cms/components/sortable";
import { type UniqueIdentifier } from "@dnd-kit/core";

type SortableStoreState = {
  activeId: UniqueIdentifier | null;
  depth: number;
  items: FlatNode[];
  offset: number;
  overId: UniqueIdentifier | null;
  parentId: UniqueIdentifier | null;
};

type SortableStoreActions = {
  setActiveId: (activeId: UniqueIdentifier | null) => void;
  setDepth: (depth: number) => void;
  setItems: (items: FlatNode[]) => void;
  setOffset: (offset: number) => void;
  setOverId: (overId: UniqueIdentifier | null) => void;
  setParentId: (parentId: UniqueIdentifier | null) => void;
};

export type SortableStoreType = SortableStoreState & SortableStoreActions;

const defaultState: SortableStoreState = {
  activeId: null,
  depth: 0,
  items: [],
  offset: 0,
  overId: null,
  parentId: null,
};

const useSortableStore = (initialState: Partial<SortableStoreState>) =>
  create<SortableStoreType>()((set) => ({
    ...defaultState,
    ...initialState,
    setActiveId: (activeId) =>
      set({
        activeId: activeId,
      }),
    setDepth: (depth) =>
      set({
        depth: depth,
      }),
    setItems: (items) =>
      set({
        items: items,
      }),
    setOffset: (offset) =>
      set({
        offset: offset,
      }),
    setOverId: (overId) =>
      set({
        overId: overId,
      }),
    setParentId: (parentId) =>
      set({
        parentId: parentId,
      }),
  }));

export default useSortableStore;
