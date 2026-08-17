import { Link, router, usePage } from "@inertiajs/react";
import { type GlobalProps } from "@narsil-cms/hooks/use-props";
import { Bookmarks } from "@narsil-ui/blocks/bookmarks";
import { Select } from "@narsil-ui/blocks/select";
import { Themes } from "@narsil-ui/blocks/themes";
import { Tooltip } from "@narsil-ui/blocks/tooltip";
import { AlertDescription, AlertRoot, AlertTitle } from "@narsil-ui/components/alert";
import { AvatarFallback, AvatarImage, AvatarRoot } from "@narsil-ui/components/avatar";
import { Button } from "@narsil-ui/components/button";
import {
  DropdownMenuItem,
  DropdownMenuPopup,
  DropdownMenuPortal,
  DropdownMenuPositioner,
  DropdownMenuRoot,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@narsil-ui/components/dropdown-menu";
import { Heading } from "@narsil-ui/components/heading";
import { Icon } from "@narsil-ui/components/icon";
import { ModalLink } from "@narsil-ui/components/modal";
import { useTranslator } from "@narsil-ui/components/translator";
import { NarsilSwitcher } from "@narsil-ui/components/narsil-switcher";
import { groupBy } from "lodash-es";
import { Fragment, useMemo, useState } from "react";
import { route } from "ziggy-js";
import { ContentTree } from "./content-tree";
import { useLiveEditor, useLiveEditorState } from "./live-editor-context";
import { NodeInspector } from "./node-inspector";
import { PageTree } from "./page-tree";
import { PreviewFrame } from "./preview-frame";

function LiveEditorLayout() {
  const { trans } = useTranslator();

  const { auth, navigation, session } = usePage<GlobalProps>().props;

  const editor = useLiveEditor();
  const { error } = useLiveEditorState();

  const { country, countries, siteLabel } = editor.bootstrap;
  const [previewLanguage, setPreviewLanguage] = useState(session.locale);
  const [previewCountry, setPreviewCountry] = useState(country);
  const groupedMenu = groupBy(navigation.userMenu, (item) => item.group ?? "default");

  const previewUrl = useMemo(() => {
    if (!editor.bootstrap.previewUrl) {
      return null;
    }

    const url = new URL(editor.bootstrap.previewUrl, window.location.origin);

    url.searchParams.set("_country", previewCountry);
    url.searchParams.set("_preview_language", previewLanguage);

    return url.toString();
  }, [editor.bootstrap.previewUrl, previewCountry, previewLanguage]);

  function onCountryChange(value: string): void {
    setPreviewCountry(value);

    router.get(window.location.pathname, { country: value }, { preserveState: false });
  }

  function onSchemaChange(value: string): void {
    router.post(
      route("user-configurations.update"),
      {
        schema: value,
      },
      {
        preserveState: false,
      },
    );
  }

  return (
    <div className="grid h-screen min-h-0 grid-rows-[3.25rem_1fr] overflow-hidden bg-background text-foreground">
      <header className="grid grid-cols-[280px_1fr_380px] border-b">
        <div className="text-sidebar-foreground flex h-13 items-center gap-3 border-r border-b bg-sidebar px-2">
          <NarsilSwitcher />
        </div>
        <div className="flex min-w-0 items-center gap-2 border-b bg-background px-4">
          {siteLabel ? <span className="truncate text-sm font-medium">{siteLabel}</span> : null}
          <div className="ml-auto flex items-center gap-2">
            {countries.length > 0 ? (
              <div className="flex items-center gap-1">
                <Select
                  aria-label={trans("live-editor.country")}
                  className="min-w-24"
                  options={countries}
                  value={previewCountry}
                  onValueChange={(value) => onCountryChange(value as string)}
                />
              </div>
            ) : null}
            {session.languages.length > 1 ? (
              <div className="flex items-center gap-1">
                <Select
                  aria-label={trans("live-editor.language")}
                  className="min-w-24"
                  options={session.languages}
                  value={previewLanguage}
                  onValueChange={(value) => setPreviewLanguage(value as string)}
                />
              </div>
            ) : null}
          </div>
        </div>
        <div className="flex h-13 items-center justify-end gap-2 border-b border-l bg-background px-4">
          {session.schemas.length > 1 ? (
            <div className="flex items-center gap-1">
              <Select
                aria-label={trans("live-editor.workspace")}
                className="min-w-24"
                options={session.schemas}
                value={session.schema}
                onValueChange={(value) => onSchemaChange(value as string)}
              />
            </div>
          ) : null}
          <Bookmarks breadcrumb={navigation.breadcrumb} />
          <DropdownMenuRoot>
            <Tooltip tooltip={trans("accessibility.user_menu")}>
              <DropdownMenuTrigger>
                <AvatarRoot>
                  {auth.avatar ? (
                    <AvatarImage src={auth.avatar} alt={auth.full_name ?? "User"} />
                  ) : null}
                  <AvatarFallback>
                    <Icon name="user" />
                  </AvatarFallback>
                </AvatarRoot>
              </DropdownMenuTrigger>
            </Tooltip>
            <DropdownMenuPortal>
              <DropdownMenuPositioner align="end">
                <DropdownMenuPopup>
                  {Object.entries(groupedMenu).map(([group, items], groupIndex) => {
                    return (
                      <Fragment key={group}>
                        {groupIndex > 0 ? <DropdownMenuSeparator /> : null}
                        {items.map((item, index) => {
                          return (
                            <DropdownMenuItem
                              key={index}
                              render={
                                <Button
                                  size="sm"
                                  variant="ghost"
                                  render={
                                    item.modal ? (
                                      <ModalLink
                                        href={route(item.route, item.parameters)}
                                        method={item.method}
                                      >
                                        {item.icon ? <Icon name={item.icon} /> : null}
                                        {item.label}
                                      </ModalLink>
                                    ) : (
                                      <Link
                                        href={route(item.route, item.parameters)}
                                        method={item.method}
                                      >
                                        {item.icon ? <Icon name={item.icon} /> : null}
                                        {item.label}
                                      </Link>
                                    )
                                  }
                                />
                              }
                            />
                          );
                        })}
                      </Fragment>
                    );
                  })}
                  <DropdownMenuSeparator />
                  <Themes className="w-full" />
                </DropdownMenuPopup>
              </DropdownMenuPositioner>
            </DropdownMenuPortal>
          </DropdownMenuRoot>
        </div>
      </header>

      <div className="grid min-h-0 grid-cols-[280px_1fr_380px]">
        <aside className="text-sidebar-foreground flex min-h-0 flex-col overflow-hidden border-r bg-sidebar">
          <PageTree />
          <div className="flex h-13 shrink-0 items-center border-b px-4">
            <Heading level="h2">{trans("live-editor.tree.title")}</Heading>
          </div>
          <div className="min-h-0 grow overflow-y-auto">
            <ContentTree />
          </div>
        </aside>

        <main className="min-h-0 overflow-hidden bg-muted">
          {error ? (
            <AlertRoot className="m-4 w-auto" variant="destructive">
              <AlertTitle>{trans("live-editor.title")}</AlertTitle>
              <AlertDescription>{error}</AlertDescription>
            </AlertRoot>
          ) : null}
          <PreviewFrame key={previewUrl} previewUrl={previewUrl} />
        </main>

        <aside className="min-h-0 overflow-hidden border-l">
          <NodeInspector />
        </aside>
      </div>
    </div>
  );
}

export default LiveEditorLayout;
