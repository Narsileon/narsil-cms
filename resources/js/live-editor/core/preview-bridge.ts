import type { PreviewBridgeCommand, PreviewBridgeEvent } from "./types";

export const NODE_ATTRIBUTE = "data-narsil-node";

const EDITOR_SOURCE = "narsil-live-editor";
const PREVIEW_SOURCE = "narsil-live-editor-preview";
const OVERLAY_ID = "narsil-live-editor-overlay";

/**
 * Spread onto the root element of a rendered block so the preview can map it
 * back to its entity node.
 */
export function nodeAttributes(nodeId?: string | null): Record<string, string> {
  return nodeId ? { [NODE_ATTRIBUTE]: nodeId } : {};
}

export type PreviewBridgeOptions = {
  iframe: HTMLIFrameElement;
  /**
   * Passed in rather than assumed, so a preview served from another hostname
   * keeps working.
   */
  origin?: string;
  onReady?: () => void;
  onSelect?: (nodeId: string) => void;
};

export type PreviewBridge = {
  highlight: (nodeId: string | null) => void;
  scrollToNode: (nodeId: string) => void;
  destroy: () => void;
};

/**
 * The editor half of the bridge.
 */
export function createPreviewBridge({
  iframe,
  origin,
  onReady,
  onSelect,
}: PreviewBridgeOptions): PreviewBridge {
  const targetOrigin = origin ?? window.location.origin;

  function onMessage(event: MessageEvent<PreviewBridgeEvent>) {
    if (
      event.source !== iframe.contentWindow ||
      event.data?.source !== PREVIEW_SOURCE
    ) {
      return;
    }

    if (event.data.type === "ready") {
      onReady?.();
    }

    if (event.data.type === "select" && event.data.nodeId) {
      onSelect?.(event.data.nodeId);
    }
  }

  function send(command: Omit<PreviewBridgeCommand, "source">) {
    iframe.contentWindow?.postMessage(
      { ...command, source: EDITOR_SOURCE },
      targetOrigin,
    );
  }

  window.addEventListener("message", onMessage);

  return {
    highlight: (nodeId) => send({ nodeId: nodeId, type: "highlight" }),
    scrollToNode: (nodeId) => send({ nodeId: nodeId, type: "scroll" }),
    destroy: () => window.removeEventListener("message", onMessage),
  };
}

/**
 * The preview half of the bridge, called by the public frontend when it is
 * rendered inside the editor.
 */
export function initPreviewBridge(): () => void {
  if (window.parent === window) {
    return () => undefined;
  }

  const overlay = document.createElement("div");

  overlay.id = OVERLAY_ID;
  overlay.style.cssText = [
    "position:absolute",
    "z-index:2147483647",
    "pointer-events:none",
    "border:2px solid rgb(59 130 246)",
    "background:rgb(59 130 246 / 0.08)",
    "border-radius:2px",
    "transition:all 120ms ease-out",
    "display:none",
  ].join(";");

  document.body.appendChild(overlay);

  let selectedNodeId: string | null = null;

  function findNode(target: EventTarget | null): HTMLElement | null {
    if (!(target instanceof Element)) {
      return null;
    }

    return target.closest<HTMLElement>(`[${NODE_ATTRIBUTE}]`);
  }

  function elementFor(nodeId: string | null): HTMLElement | null {
    if (!nodeId) {
      return null;
    }

    return document.querySelector<HTMLElement>(
      `[${NODE_ATTRIBUTE}="${nodeId}"]`,
    );
  }

  function drawOverlay(element: HTMLElement | null) {
    if (!element) {
      overlay.style.display = "none";

      return;
    }

    const rect = element.getBoundingClientRect();

    overlay.style.display = "block";
    overlay.style.height = `${rect.height}px`;
    overlay.style.left = `${rect.left + window.scrollX}px`;
    overlay.style.top = `${rect.top + window.scrollY}px`;
    overlay.style.width = `${rect.width}px`;
  }

  function send(event: Omit<PreviewBridgeEvent, "source">) {
    window.parent.postMessage({ ...event, source: PREVIEW_SOURCE }, "*");
  }

  function onClick(event: MouseEvent) {
    const element = findNode(event.target);

    if (!element) {
      return;
    }

    event.preventDefault();
    event.stopPropagation();

    selectedNodeId = element.getAttribute(NODE_ATTRIBUTE);

    drawOverlay(element);

    if (selectedNodeId) {
      send({ nodeId: selectedNodeId, type: "select" });
    }
  }

  function onMouseOver(event: MouseEvent) {
    drawOverlay(findNode(event.target) ?? elementFor(selectedNodeId));
  }

  function onMouseOut() {
    drawOverlay(elementFor(selectedNodeId));
  }

  function onReposition() {
    drawOverlay(elementFor(selectedNodeId));
  }

  function onMessage(event: MessageEvent<PreviewBridgeCommand>) {
    if (event.data?.source !== EDITOR_SOURCE) {
      return;
    }

    const element = elementFor(event.data.nodeId ?? null);

    if (event.data.type === "highlight") {
      selectedNodeId = event.data.nodeId ?? null;

      drawOverlay(element);
    }

    if (event.data.type === "scroll") {
      element?.scrollIntoView({ behavior: "smooth", block: "center" });
    }
  }

  document.addEventListener("click", onClick, true);
  document.addEventListener("mouseover", onMouseOver, true);
  document.addEventListener("mouseout", onMouseOut, true);
  window.addEventListener("message", onMessage);
  window.addEventListener("resize", onReposition);
  window.addEventListener("scroll", onReposition, true);

  send({ type: "ready" });

  return () => {
    document.removeEventListener("click", onClick, true);
    document.removeEventListener("mouseover", onMouseOver, true);
    document.removeEventListener("mouseout", onMouseOut, true);
    window.removeEventListener("message", onMessage);
    window.removeEventListener("resize", onReposition);
    window.removeEventListener("scroll", onReposition, true);

    overlay.remove();
  };
}
