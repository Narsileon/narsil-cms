import { createLiveEditor, type LiveEditor } from "./live-editor";
import { createPreviewBridge } from "./preview-bridge";
import type { LiveEditorBootstrap } from "./types";

export type MountedLiveEditor = LiveEditor & {
  destroy: () => void;
};

/**
 * Entry point for hosts that are not React, for instance a Blade or Livewire
 * page. The bootstrap is either passed in or read from a
 * `<script type="application/json">` child of the element.
 */
export function mountLiveEditor(
  element: HTMLElement,
  bootstrap?: LiveEditorBootstrap,
): MountedLiveEditor {
  const payload = bootstrap ?? readBootstrap(element);

  if (!payload) {
    throw new Error("The live editor needs a bootstrap payload to mount.");
  }

  const editor = createLiveEditor(payload);

  const iframe = element.querySelector("iframe");

  const bridge = iframe
    ? createPreviewBridge({
        iframe: iframe,
        onSelect: (nodeId) => editor.selectNode(nodeId),
      })
    : null;

  const unsubscribe = editor.store.subscribe(() => {
    const { selectedNodeId } = editor.store.getState();

    bridge?.highlight(selectedNodeId);

    element.dispatchEvent(
      new CustomEvent("narsil:live-editor-change", {
        detail: editor.store.getState(),
      }),
    );
  });

  return {
    ...editor,
    destroy: () => {
      unsubscribe();
      bridge?.destroy();
    },
  };
}

function readBootstrap(element: HTMLElement): LiveEditorBootstrap | null {
  const script = element.querySelector('script[type="application/json"]');

  if (!script?.textContent) {
    return null;
  }

  return JSON.parse(script.textContent) as LiveEditorBootstrap;
}
