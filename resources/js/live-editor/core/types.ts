import type { FormData, OptionData } from "@narsil-ui/types";

export type ContentTreeNodeType = "block" | "builder";

export type AllowedBlockData = {
  block_id: number;
  handle: string;
  icon: string | null;
  label: string | null;
};

export type ContentTreeNodeMeta = {
  canAddChild: boolean;
  canDelete: boolean;
  canDrag: boolean;
  selectable: boolean;
};

export type ContentTreeNode = {
  active?: boolean;
  allowedBlocks?: AllowedBlockData[];
  children: ContentTreeNode[];
  handle?: string | null;
  id: string;
  label: string | null;
  meta: ContentTreeNodeMeta;
  parent_id: string | null;
  position: number;
  type: ContentTreeNodeType;
};

export type LiveEditorRoutes = {
  nodeDestroy: string;
  nodeForm: string;
  nodeReorder: string;
  nodeStore: string;
  nodeUpdate: string;
  pageCreate: string;
  sitePages: string;
};

export type PageTreeNode = {
  badge: string;
  children: PageTreeNode[];
  create_url: string;
  edit_url: string;
  id: number;
  label: string | Record<string, string>;
  live_editor_url: string;
};

export type LiveEditorBootstrap = {
  country: string;
  countries: OptionData[];
  entityUuid: string | null;
  locale: string;
  pages: PageTreeNode[];
  pageData: Record<string, unknown>;
  pageForm: FormData;
  previewUrl: string | null;
  routes: LiveEditorRoutes;
  siteLabel: string | null;
  siteHostname: string | null;
  sitePageId: number;
  sitePageTitle: string | null;
  tree: ContentTreeNode[];
};

export type InspectorPayload = {
  blockId: number;
  data: Record<string, unknown>;
  form: FormData;
  label: string | null;
  nodeUuid: string;
  routes: {
    update: string;
  };
  translations?: Record<string, string>;
};

export type TreeResponse = {
  tree: ContentTreeNode[];
};

export type CreateBlockResponse = TreeResponse & {
  nodeUuid: string;
};

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

export type PreviewBridgeMessage = PreviewBridgeCommand | PreviewBridgeEvent;
