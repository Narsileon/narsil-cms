import {
  createContext,
  useContext,
  useMemo,
  useSyncExternalStore,
  type ReactNode,
} from "react";
import { createLiveEditor, type LiveEditor } from "../core/live-editor";
import type { LiveEditorState } from "../core/live-editor-store";
import type { LiveEditorBootstrap } from "../core/types";

const LiveEditorContext = createContext<LiveEditor | null>(null);

type LiveEditorProviderProps = {
  bootstrap: LiveEditorBootstrap;
  children: ReactNode;
};

function LiveEditorProvider({ bootstrap, children }: LiveEditorProviderProps) {
  const editor = useMemo(() => createLiveEditor(bootstrap), [bootstrap]);

  return (
    <LiveEditorContext.Provider value={editor}>
      {children}
    </LiveEditorContext.Provider>
  );
}

function useLiveEditor(): LiveEditor {
  const editor = useContext(LiveEditorContext);

  if (!editor) {
    throw new Error("useLiveEditor must be used inside a LiveEditorProvider.");
  }

  return editor;
}

function useLiveEditorState(): LiveEditorState {
  const { store } = useLiveEditor();

  return useSyncExternalStore(store.subscribe, store.getState, store.getState);
}

export { LiveEditorProvider, useLiveEditor, useLiveEditorState };
