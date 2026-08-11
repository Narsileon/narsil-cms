import { Link } from "@inertiajs/react";
import { Tooltip } from "@narsil-ui/blocks/tooltip";
import {
  AlertDescription,
  AlertRoot,
  AlertTitle,
} from "@narsil-ui/components/alert";
import { Button } from "@narsil-ui/components/button";
import { Heading } from "@narsil-ui/components/heading";
import { Icon } from "@narsil-ui/components/icon";
import { useTranslator } from "@narsil-ui/components/translator";
import { ContentTree } from "./content-tree";
import { useLiveEditor, useLiveEditorState } from "./live-editor-context";
import { NodeInspector } from "./node-inspector";
import { PreviewFrame } from "./preview-frame";

function LiveEditorLayout() {
  const { trans } = useTranslator();

  const editor = useLiveEditor();
  const { error } = useLiveEditorState();

  const { previewUrl, routes, sitePageTitle } = editor.bootstrap;

  return (
    <div className="grid h-screen grid-rows-[3.25rem_1fr] bg-background text-foreground">
      <header className="flex items-center gap-3 border-b px-3">
        <Icon className="size-5 shrink-0" name="layers" />
        <div className="flex min-w-0 items-baseline gap-2">
          <Heading className="truncate" level="h1">
            {trans("live_editor.title")}
          </Heading>
          {sitePageTitle ? (
            <span className="truncate text-sm text-muted-foreground">
              {sitePageTitle}
            </span>
          ) : null}
        </div>
        <div className="ml-auto flex items-center gap-1">
          <Tooltip tooltip={trans("live_editor.preview.title")}>
            <Button
              aria-label={trans("live_editor.preview.title")}
              size="icon-sm"
              variant="ghost"
              onClick={() => editor.store.refreshPreview()}
            >
              <Icon name="refresh" />
            </Button>
          </Tooltip>
          <Tooltip tooltip={trans("ui.close")}>
            <Button
              aria-label={trans("ui.close")}
              nativeButton={false}
              size="icon-sm"
              variant="ghost"
              render={
                <Link href={routes.sitePages}>
                  <Icon name="x" />
                </Link>
              }
            />
          </Tooltip>
        </div>
      </header>

      <div className="grid min-h-0 grid-cols-[280px_1fr_380px]">
        <aside className="flex min-h-0 flex-col overflow-hidden border-r">
          <div className="flex h-13 shrink-0 items-center border-b px-4">
            <Heading level="h2">{trans("live_editor.tree.title")}</Heading>
          </div>
          <div className="min-h-0 grow overflow-y-auto">
            <ContentTree />
          </div>
        </aside>

        <main className="min-h-0 overflow-hidden bg-muted">
          {error ? (
            <AlertRoot className="m-4 w-auto" variant="destructive">
              <AlertTitle>{trans("live_editor.title")}</AlertTitle>
              <AlertDescription>{error}</AlertDescription>
            </AlertRoot>
          ) : null}
          <PreviewFrame key={previewUrl} />
        </main>

        <aside className="min-h-0 overflow-hidden border-l">
          <NodeInspector />
        </aside>
      </div>
    </div>
  );
}

export default LiveEditorLayout;
