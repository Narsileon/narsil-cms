import type Alpine from "alpinejs";
import { createPreviewBridge, type PreviewBridge } from "./core/preview-bridge";

type LiveEditorWire = {
  addNode: (parentUuid: string, blockId: number) => void;
  selectNode: (nodeId: string) => void;
  reorderNodes: (parentUuid: string, orderedUuids: string[]) => void;
};

type LiveEditorState = {
  $root: HTMLElement;
  $wire: LiveEditorWire;
  bridge: PreviewBridge | null;
  addBlock: (parentUuid: string, blockId: number) => void;
  frame: HTMLIFrameElement | null;
  frameSource: string;
  observer: MutationObserver | null;
  selectedEvent: ((event: Event) => void) | null;
  frameLoad: (() => void) | null;
  init: () => void;
  destroy: () => void;
  syncPreview: () => void;
  selectInPreview: (nodeId: string | null) => void;
  reorder: (event: DragEvent, targetId: string) => void;
};

export default function registerLiveEditor(alpine: typeof Alpine): void {
  alpine.data(
    "narsilLiveEditor",
    (): LiveEditorState =>
      ({
        bridge: null,
        frame: null,
        frameSource: "",
        observer: null,
        selectedEvent: null,
        frameLoad: null,
        addBlock(parentUuid: string, blockId: number): void {
          this.$wire.addNode(parentUuid, blockId);
        },
        init() {
          this.selectedEvent = (event: Event): void => {
            const customEvent = event as CustomEvent<{ nodeId: string }>;
            this.selectInPreview(customEvent.detail?.nodeId ?? null);
          };

          this.$root.addEventListener(
            "narsil-live-editor-node-selected",
            this.selectedEvent,
          );
          this.observer = new MutationObserver((): void => this.syncPreview());
          this.observer.observe(this.$root, {
            attributes: true,
            attributeFilter: ["src"],
            childList: true,
            subtree: true,
          });

          this.syncPreview();
        },
        destroy() {
          this.observer?.disconnect();
          this.observer = null;

          if (this.selectedEvent) {
            this.$root.removeEventListener(
              "narsil-live-editor-node-selected",
              this.selectedEvent,
            );
          }

          if (this.frame && this.frameLoad) {
            this.frame.removeEventListener("load", this.frameLoad);
          }

          this.bridge?.destroy();
          this.bridge = null;
          this.frame = null;
        },
        syncPreview() {
          const frame = this.$root.querySelector<HTMLIFrameElement>(
            "[data-live-editor-preview]",
          );
          const source = frame?.src ?? "";

          if (!frame) {
            this.bridge?.destroy();
            this.bridge = null;
            this.frame = null;
            this.frameSource = "";

            return;
          }

          if (this.frame === frame && this.frameSource === source) {
            return;
          }

          this.bridge?.destroy();

          if (this.frame && this.frameLoad) {
            this.frame.removeEventListener("load", this.frameLoad);
          }

          this.frame = frame;
          this.frameSource = source;

          const origin = new URL(source, window.location.href).origin;

          this.bridge = createPreviewBridge({
            iframe: frame,
            origin,
            onReady: (): void =>
              this.selectInPreview(this.$root.dataset.selectedNodeId || null),
            onSelect: (nodeId: string): void => this.$wire.selectNode(nodeId),
          });

          this.frameLoad = (): void => {
            this.selectInPreview(this.$root.dataset.selectedNodeId || null);
          };
          frame.addEventListener("load", this.frameLoad);
        },
        selectInPreview(nodeId: string | null) {
          this.bridge?.highlight(nodeId);

          if (nodeId) {
            this.bridge?.scrollToNode(nodeId);
          }
        },
        reorder(event: DragEvent, targetId: string): void {
          const sourceId = event.dataTransfer?.getData("text/plain");
          const currentTarget = event.currentTarget;

          if (
            !sourceId ||
            sourceId === targetId ||
            !(currentTarget instanceof Element)
          ) {
            return;
          }

          const list = currentTarget.closest<HTMLElement>("[data-builder-id]");

          if (!list) {
            return;
          }

          const ids = Array.from(
            list.querySelectorAll<HTMLElement>(":scope > [data-editor-node]"),
          ).map((item) => item.dataset.editorNode ?? "");
          const from = ids.indexOf(sourceId);
          const to = ids.indexOf(targetId);

          if (from < 0 || to < 0) {
            return;
          }

          const [moved] = ids.splice(from, 1);
          ids.splice(to, 0, moved);
          this.$wire.reorderNodes(list.dataset.builderId ?? "", ids);
        },
      }) as LiveEditorState,
  );
}
