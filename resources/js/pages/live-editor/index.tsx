import type { LiveEditorBootstrap } from "@narsil-cms/live-editor/core/types";
import {
  LiveEditorLayout,
  LiveEditorProvider,
  LiveEditorShell,
} from "@narsil-cms/live-editor/react";
import { useMemo, type ComponentProps } from "react";

type LiveEditorPageProps = LiveEditorBootstrap;

function LiveEditorPage({
  entityUuid,
  locale,
  previewUrl,
  routes,
  siteHostname,
  sitePageId,
  sitePageTitle,
  tree,
}: LiveEditorPageProps) {
  const bootstrap = useMemo<LiveEditorBootstrap>(
    () => ({
      entityUuid: entityUuid,
      locale: locale,
      previewUrl: previewUrl,
      routes: routes,
      siteHostname: siteHostname,
      sitePageId: sitePageId,
      sitePageTitle: sitePageTitle,
      tree: tree,
    }),
    [
      entityUuid,
      locale,
      previewUrl,
      routes,
      siteHostname,
      sitePageId,
      sitePageTitle,
      tree,
    ],
  );

  return (
    <LiveEditorProvider bootstrap={bootstrap}>
      <LiveEditorLayout />
    </LiveEditorProvider>
  );
}

LiveEditorPage.layout = (
  page: ComponentProps<typeof LiveEditorShell>["children"],
) => <LiveEditorShell children={page} />;

export default LiveEditorPage;
