import type {
  ContentTreeNode,
  InspectorPayload,
  LiveEditorBootstrap,
} from "./types";

export type LiveEditorState = {
  error: string | null;
  inspector: InspectorPayload | null;
  loadingInspector: boolean;
  previewKey: number;
  saving: boolean;
  selectedNodeId: string | null;
  tree: ContentTreeNode[];
};

export type LiveEditorStore = {
  getState: () => LiveEditorState;
  subscribe: (listener: () => void) => () => void;
  setError: (error: string | null) => void;
  setInspector: (inspector: InspectorPayload | null) => void;
  setLoadingInspector: (loading: boolean) => void;
  setSaving: (saving: boolean) => void;
  setSelectedNodeId: (nodeId: string | null) => void;
  setTree: (tree: ContentTreeNode[]) => void;
  refreshPreview: () => void;
};

export function createLiveEditorStore(
  bootstrap: LiveEditorBootstrap,
): LiveEditorStore {
  let state: LiveEditorState = {
    error: null,
    inspector: null,
    loadingInspector: false,
    previewKey: 0,
    saving: false,
    selectedNodeId: null,
    tree: bootstrap.tree ?? [],
  };

  const listeners = new Set<() => void>();

  // A new object every time, so consumers comparing snapshots by identity
  // (React's useSyncExternalStore among them) see the change.
  function update(partial: Partial<LiveEditorState>) {
    state = { ...state, ...partial };

    listeners.forEach((listener) => listener());
  }

  return {
    getState: () => state,
    subscribe: (listener) => {
      listeners.add(listener);

      return () => {
        listeners.delete(listener);
      };
    },
    setError: (error) => update({ error: error }),
    setInspector: (inspector) => update({ inspector: inspector }),
    setLoadingInspector: (loading) => update({ loadingInspector: loading }),
    setSaving: (saving) => update({ saving: saving }),
    setSelectedNodeId: (nodeId) => update({ selectedNodeId: nodeId }),
    setTree: (tree) => update({ tree: tree }),
    refreshPreview: () => update({ previewKey: state.previewKey + 1 }),
  };
}
