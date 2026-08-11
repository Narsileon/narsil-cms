import { Icon } from "@narsil-ui/components/icon";
import { useTranslator } from "@narsil-ui/components/translator";
import { useEffect, useRef } from "react";
import {
  createPreviewBridge,
  type PreviewBridge,
} from "../../core/preview-bridge";
import { useLiveEditor, useLiveEditorState } from "../live-editor-context";

function PreviewFrame() {
  const { trans } = useTranslator();

  const editor = useLiveEditor();
  const { previewKey, selectedNodeId } = useLiveEditorState();

  const bridgeRef = useRef<PreviewBridge | null>(null);
  const iframeRef = useRef<HTMLIFrameElement>(null);

  const { previewUrl } = editor.bootstrap;

  useEffect(() => {
    if (!iframeRef.current) {
      return;
    }

    const bridge = createPreviewBridge({
      iframe: iframeRef.current,
      onReady: () => bridge.highlight(editor.store.getState().selectedNodeId),
      onSelect: (nodeId) => editor.selectNode(nodeId),
    });

    bridgeRef.current = bridge;

    return () => {
      bridge.destroy();

      bridgeRef.current = null;
    };
    // previewKey remounts the iframe, so the bridge has to be rebound to the
    // new contentWindow or it stops recognizing messages from the preview.
  }, [editor, previewKey, previewUrl]);

  useEffect(() => {
    bridgeRef.current?.highlight(selectedNodeId);

    if (selectedNodeId) {
      bridgeRef.current?.scrollToNode(selectedNodeId);
    }
  }, [selectedNodeId]);

  if (!previewUrl) {
    return (
      <div className="flex h-full flex-col items-center justify-center gap-2 p-8 text-center">
        <Icon className="size-6 text-muted-foreground" name="file" />
        <p className="max-w-sm text-sm text-muted-foreground">
          {trans("live_editor.preview.missing")}
        </p>
      </div>
    );
  }

  return (
    <iframe
      // Reloading on a key change is what makes a save show up in the preview.
      key={previewKey}
      ref={iframeRef}
      className="h-full w-full border-0 bg-white"
      src={previewUrl}
      title={trans("live_editor.preview.title")}
    />
  );
}

export default PreviewFrame;
