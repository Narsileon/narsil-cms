import type { LiveEditorBootstrap } from "@narsil-cms/live-editor/core/types";
import {
  LiveEditorLayout,
  LiveEditorProvider,
  LiveEditorShell,
} from "@narsil-cms/live-editor/react";
import { useMemo, type ComponentProps } from "react";

type LiveEditorPageProps = LiveEditorBootstrap;

function LiveEditorPage({
  country,
  countries,
  entityUuid,
  locale,
  pageData,
  pageForm,
  pages,
  previewUrl,
  routes,
  siteLabel,
  siteHostname,
  sitePageId,
  sitePageTitle,
  tree,
}: LiveEditorPageProps) {
  const bootstrap = useMemo<LiveEditorBootstrap>(
    () => ({
      country: country,
      countries: countries,
      entityUuid: entityUuid,
      locale: locale,
      pageData: pageData,
      pageForm: pageForm,
      pages: pages,
      previewUrl: previewUrl,
      routes: routes,
      siteLabel: siteLabel,
      siteHostname: siteHostname,
      sitePageId: sitePageId,
      sitePageTitle: sitePageTitle,
      tree: tree,
    }),
    [
      country,
      countries,
      entityUuid,
      locale,
      pageData,
      pageForm,
      pages,
      previewUrl,
      routes,
      siteLabel,
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
