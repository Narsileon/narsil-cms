/**
 * Sent by the editor to the preview.
 */
export type PreviewBridgeCommand = {
  nodeId?: string | null;
  source: "narsil-live-editor";
  type: "highlight" | "scroll";
};

/**
 * Sent by the preview to the editor.
 */
export type PreviewBridgeEvent = {
  nodeId?: string | null;
  source: "narsil-live-editor-preview";
  type: "ready" | "select";
};
