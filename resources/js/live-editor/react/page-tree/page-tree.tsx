import { Link } from "@inertiajs/react";
import { Button } from "@narsil-ui/components/button";
import { Heading } from "@narsil-ui/components/heading";
import { Icon } from "@narsil-ui/components/icon";
import { useTranslator } from "@narsil-ui/components/translator";
import { cn } from "@narsil-ui/lib/utils";
import type { PageTreeNode } from "../../core/types";
import { useLiveEditor } from "../live-editor-context";

type PageTreeItemProps = {
  currentPageId: number;
  locale: string;
  node: PageTreeNode;
};

function getPageLabel(label: string | Record<string, string>, locale: string): string {
  if (typeof label === "string") {
    return label;
  }

  return label[locale] ?? Object.values(label)[0] ?? "";
}

function PageTreeItem({ currentPageId, locale, node }: PageTreeItemProps) {
  const { trans } = useTranslator();

  const selected = node.id === currentPageId;
  const label = getPageLabel(node.label, locale);

  return (
    <li className="list-none">
      <div
        className={cn(
          "group flex items-center gap-1 overflow-hidden rounded border pr-1",
          selected ? "border-primary bg-accent" : "border-transparent hover:bg-accent/50",
        )}
      >
        <Link
          className="flex min-w-0 grow items-center gap-2 px-2 py-1.5 text-left text-sm"
          href={node.live_editor_url}
        >
          <Icon className="size-4 shrink-0" name="file" />
          <span className="truncate">{label}</span>
        </Link>
        <Button
          aria-label={trans("live-editor.pages.create")}
          className="shrink-0 opacity-0 group-hover:opacity-100"
          nativeButton={false}
          render={<Link href={node.create_url} />}
          size="icon-sm"
          variant="ghost"
        >
          <Icon name="plus" />
        </Button>
      </div>
      {node.children.length > 0 ? (
        <div className="mt-1 ml-3 border-l pl-2">
          <ul className="grid gap-1">
            {node.children.map((child) => {
              return (
                <PageTreeItem
                  currentPageId={currentPageId}
                  key={child.id}
                  locale={locale}
                  node={child}
                />
              );
            })}
          </ul>
        </div>
      ) : null}
    </li>
  );
}

function PageTree() {
  const { trans } = useTranslator();

  const editor = useLiveEditor();
  const { locale, routes, sitePageId } = editor.bootstrap;
  const pages = editor.bootstrap.pages ?? [];

  return (
    <div className="flex min-h-0 basis-2/5 flex-col border-b">
      <div className="flex h-13 shrink-0 items-center justify-between gap-2 border-b px-4">
        <Heading level="h2">{trans("live-editor.pages.title")}</Heading>
        <Button
          aria-label={trans("live-editor.pages.create")}
          nativeButton={false}
          render={<Link href={routes.pageCreate} />}
          size="icon-sm"
          variant="ghost"
        >
          <Icon name="plus" />
        </Button>
      </div>
      <div className="min-h-0 grow overflow-y-auto p-3">
        {pages.length > 0 ? (
          <ul className="grid gap-1">
            {pages.map((page) => {
              return (
                <PageTreeItem
                  currentPageId={sitePageId}
                  key={page.id}
                  locale={locale}
                  node={page}
                />
              );
            })}
          </ul>
        ) : (
          <p className="text-sm text-muted-foreground">{trans("live-editor.pages.empty")}</p>
        )}
      </div>
    </div>
  );
}

export default PageTree;
