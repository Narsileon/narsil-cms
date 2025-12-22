import { router } from "@inertiajs/react";
import { Button, Card, Tooltip } from "@narsil-cms/blocks";
import { FormProvider, FormRenderer, FormRoot } from "@narsil-cms/components/form";
import { useLocalization } from "@narsil-cms/components/localization";
import {
  PopoverContent,
  PopoverPortal,
  PopoverRoot,
  PopoverTrigger,
} from "@narsil-cms/components/popover";
import type { Bookmark, FormType } from "@narsil-cms/types";
import { sortBy } from "lodash-es";
import { useEffect, useState, type ComponentProps } from "react";
import { route } from "ziggy-js";

type BookmarksProps = ComponentProps<typeof PopoverTrigger> & {
  breadcrumb: {
    href: string;
    label: string;
  }[];
};

function Bookmarks({ breadcrumb, ...props }: BookmarksProps) {
  const { trans } = useLocalization();

  const [bookmark, setBookmark] = useState<Bookmark | null>(null);
  const [bookmarks, setBookmarks] = useState<Bookmark[]>([]);
  const [form, setForm] = useState<FormType | null>(null);
  const [translations, setTranslations] = useState<Record<string, string>>({});
  const [open, onOpenChange] = useState<boolean>(false);

  const name = breadcrumb.map((item) => item.label).join(" > ");
  const url = window.location.origin + window.location.pathname;

  const currentBookmark = bookmarks.find((bookmark) => bookmark.url === url);

  function onAdd() {
    router.post(
      route("user-bookmarks.store"),
      {
        name: name,
        url: url,
      },
      {
        onSuccess: async () => {
          await fetchBookmarks();
        },
      },
    );
  }

  function onDelete(id: number) {
    router.delete(route("user-bookmarks.destroy", id), {
      onSuccess: () => {
        fetchBookmarks();
      },
    });
  }

  async function fetchBookmarks() {
    try {
      const response = await fetch(route("user-bookmarks.index"));

      const data = await response.json();

      setBookmarks(sortBy(data.data, "name"));
      setForm(data.meta.form);
      setTranslations(data.meta.translations);
    } catch (error) {
      console.error("[Bookmarks] Error fetching bookmarks:", error);
    }
  }

  useEffect(() => {
    if (!open) {
      return;
    }

    fetchBookmarks();
  }, [open]);

  return (
    <PopoverRoot open={open} onOpenChange={onOpenChange}>
      <Tooltip tooltip={trans("bookmarks.tooltip")}>
        <PopoverTrigger asChild={true} {...props}>
          <Button
            aria-label={trans("bookmarks.tooltip")}
            iconProps={{
              fill: "currentColor",
              name: "star",
            }}
            size="icon"
            variant="ghost"
          />
        </PopoverTrigger>
      </Tooltip>
      <PopoverPortal>
        <PopoverContent className="border-none p-0">
          {bookmark && form ? (
            <FormProvider
              action={route("user-bookmarks.update", bookmark.id)}
              id={form.id}
              elements={form.layout}
              method="patch"
              initialValues={{
                name: bookmark?.name,
              }}
              render={() => {
                return (
                  <Card
                    footerButtons={[
                      {
                        label: translations["ui.cancel"],
                        size: "sm",
                        variant: "secondary",
                        onClick: () => setBookmark(null),
                      },
                      {
                        form: form.id,
                        label: form.submitLabel,
                        size: "sm",
                        type: "submit",
                      },
                    ]}
                    footerProps={{
                      className: "border-t justify-between",
                    }}
                    headerProps={{
                      className: "border-b",
                    }}
                    title={form.title}
                  >
                    <FormRoot
                      className="grid-cols-12 gap-4"
                      options={{
                        onSuccess: () => {
                          fetchBookmarks();
                          setBookmark(null);
                        },
                      }}
                    >
                      {form.layout.map((element, index) => {
                        return <FormRenderer {...element} key={index} />;
                      })}
                    </FormRoot>
                  </Card>
                );
              }}
            />
          ) : (
            <Card
              headerButtons={[
                {
                  className: "-my-2 size-8",
                  iconProps: {
                    fill: currentBookmark ? "currentColor" : "none",
                    name: "star",
                  },
                  size: "icon",
                  tooltip: currentBookmark ? translations["ui.remove"] : translations["ui.add"],
                  variant: "ghost",
                  onClick: () => {
                    if (currentBookmark) {
                      onDelete(currentBookmark.id);
                    } else {
                      onAdd();
                    }
                  },
                },
              ]}
              headerProps={{
                className: "flex items-center justify-between border-b",
              }}
              title={translations["ui.bookmarks"]}
            >
              {bookmarks.length > 0 ? (
                <ul className="-my-2 flex flex-col gap-1">
                  {bookmarks.map((bookmark) => {
                    return (
                      <li className="flex items-center justify-between" key={bookmark.id}>
                        <Button
                          className="font-normal text-foreground"
                          linkProps={{
                            href: bookmark.url,
                          }}
                          size="link"
                          variant="link"
                          onClick={() => onOpenChange(false)}
                        >
                          {bookmark.name}
                        </Button>
                        <div className="flex items-center justify-between gap-1">
                          <Button
                            className="size-8"
                            iconProps={{
                              className: "size-4",
                              name: "edit",
                            }}
                            size="icon"
                            tooltip={translations["ui.edit"]}
                            variant="ghost"
                            onClick={() => {
                              setBookmark(bookmark);
                            }}
                          />
                          <Button
                            className="size-8"
                            iconProps={{
                              className: "size-4",
                              name: "star-off",
                            }}
                            size="icon"
                            tooltip={translations["ui.remove"]}
                            variant="ghost"
                            onClick={() => {
                              onDelete(bookmark.id);
                            }}
                          />
                        </div>
                      </li>
                    );
                  })}
                </ul>
              ) : (
                <p className="text-muted-foreground">{translations["bookmarks.instruction"]}</p>
              )}
            </Card>
          )}
        </PopoverContent>
      </PopoverPortal>
    </PopoverRoot>
  );
}

export default Bookmarks;
