import { createLiveEditorApi, type LiveEditorApi } from "./api-client";
import {
  createLiveEditorStore,
  type LiveEditorStore,
} from "./live-editor-store";
import { reorderChildren } from "./tree-utils";
import type { LiveEditorBootstrap } from "./types";

export type LiveEditor = {
  api: LiveEditorApi;
  bootstrap: LiveEditorBootstrap;
  store: LiveEditorStore;
  addBlock: (
    parentUuid: string,
    blockId: number,
    position?: number | null,
  ) => Promise<void>;
  deleteNode: (nodeUuid: string) => Promise<void>;
  reorderNodes: (parentUuid: string, uuids: string[]) => Promise<void>;
  saveNode: (
    nodeUuid: string,
    attributes: Record<string, unknown>,
  ) => Promise<void>;
  selectNode: (nodeId: string | null) => Promise<void>;
};

/**
 * The whole editor behavior, with no rendering and no framework. A React,
 * Livewire or Vue host renders whatever it likes on top of the store.
 */
export function createLiveEditor(bootstrap: LiveEditorBootstrap): LiveEditor {
  const api = createLiveEditorApi(bootstrap.routes);
  const store = createLiveEditorStore(bootstrap);

  async function guard(operation: () => Promise<void>): Promise<void> {
    store.setError(null);

    try {
      await operation();
    } catch (error) {
      store.setError(error instanceof Error ? error.message : String(error));
    }
  }

  const editor: LiveEditor = {
    api: api,
    bootstrap: bootstrap,
    store: store,
    addBlock: (parentUuid, blockId, position) =>
      guard(async () => {
        store.setSaving(true);

        try {
          const { nodeUuid, tree } = await api.createBlock(
            parentUuid,
            blockId,
            position,
          );

          store.setTree(tree);
          store.refreshPreview();

          await editor.selectNode(nodeUuid);
        } finally {
          store.setSaving(false);
        }
      }),
    deleteNode: (nodeUuid) =>
      guard(async () => {
        store.setSaving(true);

        try {
          const { tree } = await api.deleteNode(nodeUuid);

          store.setTree(tree);
          store.refreshPreview();

          if (store.getState().selectedNodeId === nodeUuid) {
            await editor.selectNode(null);
          }
        } finally {
          store.setSaving(false);
        }
      }),
    reorderNodes: (parentUuid, uuids) =>
      guard(async () => {
        store.setTree(
          reorderChildren(store.getState().tree, parentUuid, uuids),
        );

        const { tree } = await api.reorderNodes(parentUuid, uuids);

        store.setTree(tree);
        store.refreshPreview();
      }),
    saveNode: (nodeUuid, attributes) =>
      guard(async () => {
        store.setSaving(true);

        try {
          const { tree } = await api.updateNode(nodeUuid, attributes);

          store.setTree(tree);
          store.refreshPreview();
        } finally {
          store.setSaving(false);
        }
      }),
    selectNode: (nodeId) =>
      guard(async () => {
        store.setSelectedNodeId(nodeId);

        if (!nodeId) {
          store.setInspector(null);

          return;
        }

        store.setLoadingInspector(true);

        try {
          store.setInspector(await api.fetchInspector(nodeId));
        } finally {
          store.setLoadingInspector(false);
        }
      }),
  };

  return editor;
}
