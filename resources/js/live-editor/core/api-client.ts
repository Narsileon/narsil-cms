import type {
  CreateBlockResponse,
  InspectorPayload,
  LiveEditorRoutes,
  TreeResponse,
} from "./types";

export const NODE_PLACEHOLDER = "__NODE_UUID__";

export type LiveEditorApi = {
  createBlock: (
    parentUuid: string,
    blockId: number,
    position?: number | null,
  ) => Promise<CreateBlockResponse>;
  deleteNode: (nodeUuid: string) => Promise<TreeResponse>;
  fetchInspector: (nodeUuid: string) => Promise<InspectorPayload>;
  reorderNodes: (parentUuid: string, uuids: string[]) => Promise<TreeResponse>;
  updateNode: (
    nodeUuid: string,
    attributes: Record<string, unknown>,
  ) => Promise<TreeResponse>;
};

function getCookie(name: string): string | null {
  const match = document.cookie.match(new RegExp(`(^| )${name}=([^;]+)`));

  return match ? decodeURIComponent(match[2]) : null;
}

async function request<T>(
  url: string,
  method: string,
  body?: unknown,
): Promise<T> {
  const token = getCookie("XSRF-TOKEN");

  const response = await fetch(url, {
    body: body ? JSON.stringify(body) : undefined,
    credentials: "same-origin",
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json",
      "X-Requested-With": "XMLHttpRequest",
      ...(token ? { "X-XSRF-TOKEN": token } : {}),
    },
    method: method,
  });

  if (!response.ok) {
    const payload = await response.json().catch(() => null);

    throw new Error(
      payload?.message ?? `${method} ${url} failed with ${response.status}`,
    );
  }

  return (await response.json()) as T;
}

export function createLiveEditorApi(routes: LiveEditorRoutes): LiveEditorApi {
  function withNode(template: string, nodeUuid: string): string {
    return template.replace(NODE_PLACEHOLDER, encodeURIComponent(nodeUuid));
  }

  return {
    createBlock: (parentUuid, blockId, position) =>
      request<CreateBlockResponse>(routes.nodeStore, "POST", {
        blockId: blockId,
        parentUuid: parentUuid,
        position: position ?? null,
      }),
    deleteNode: (nodeUuid) =>
      request<TreeResponse>(withNode(routes.nodeDestroy, nodeUuid), "DELETE"),
    fetchInspector: (nodeUuid) =>
      request<InspectorPayload>(withNode(routes.nodeForm, nodeUuid), "GET"),
    reorderNodes: (parentUuid, uuids) =>
      request<TreeResponse>(routes.nodeReorder, "PATCH", {
        parentUuid: parentUuid,
        uuids: uuids,
      }),
    updateNode: (nodeUuid, attributes) =>
      request<TreeResponse>(
        withNode(routes.nodeUpdate, nodeUuid),
        "PATCH",
        attributes,
      ),
  };
}
