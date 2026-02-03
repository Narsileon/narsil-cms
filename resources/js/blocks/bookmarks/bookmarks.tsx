import { Link, router } from "@inertiajs/react";
import { Button } from "@narsil-cms/components/button";
import {
  CardContent,
  CardFooter,
  CardHeader,
  CardRoot,
  CardTitle,
} from "@narsil-cms/components/card";
import { FormElement, FormProvider, FormRoot } from "@narsil-cms/components/form";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import {
  PopoverPopup,
  PopoverPortal,
  PopoverPositioner,
  PopoverRoot,
  PopoverTrigger,
} from "@narsil-cms/components/popover";
import { Tooltip } from "@narsil-cms/components/tooltip";
import type { Bookmark, FormType } from "@narsil-cms/types";
import { sortBy } from "lodash-es";
import { Fragment, useEffect, useState, type ComponentProps } from "react";
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

  function onDelete(uuid: string) {
    router.delete(route("user-bookmarks.destroy", uuid), {
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
        <PopoverTrigger
          {...props}
          render={
            <Button aria-label={trans("bookmarks.tooltip")} size="icon" variant="ghost">
              <Icon fill="currentColor" name="star" />
            </Button>
          }
        />
      </Tooltip>
      <PopoverPortal>
        <PopoverPositioner>
          <PopoverPopup className="border-none p-0">
            {bookmark && form ? (
              <FormProvider
                action={route("user-bookmarks.update", bookmark.uuid)}
                id={form.id}
                elements={form.tabs}
                method="patch"
                initialValues={{
                  name: bookmark?.name,
                }}
                render={() => {
                  return (
                    <CardRoot>
                      <CardHeader className="border-b">
                        <CardTitle>{translations["ui.bookmarks"]}</CardTitle>
                      </CardHeader>
                      <CardContent>
                        <FormRoot
                          className="grid-cols-12 gap-4"
                          options={{
                            onSuccess: () => {
                              fetchBookmarks();
                              setBookmark(null);
                            },
                          }}
                        >
                          {form.tabs.map((tab, index) => {
                            return (
                              <Fragment key={index}>
                                {tab.elements?.map((element, index) => {
                                  return <FormElement {...element} key={index} />;
                                })}
                              </Fragment>
                            );
                          })}
                        </FormRoot>
                      </CardContent>
                      <CardFooter className="justify-between border-t">
                        <Button size="sm" variant="secondary" onClick={() => setBookmark(null)}>
                          {translations["ui.cancel"]}
                        </Button>
                        <Button form={form.id} size="sm" type="submit">
                          {form.submitLabel}
                        </Button>
                      </CardFooter>
                    </CardRoot>
                  );
                }}
              />
            ) : (
              <CardRoot>
                <CardHeader className="flex items-center justify-between border-b">
                  <CardTitle>{translations["ui.bookmarks"]}</CardTitle>
                  <Tooltip
                    tooltip={currentBookmark ? translations["ui.remove"] : translations["ui.add"]}
                  >
                    <Button
                      className="-my-2 size-8"
                      aria-label={
                        currentBookmark ? translations["ui.remove"] : translations["ui.add"]
                      }
                      size="icon"
                      variant="ghost"
                      onClick={() => {
                        if (currentBookmark) {
                          onDelete(currentBookmark.uuid);
                        } else {
                          onAdd();
                        }
                      }}
                    >
                      <Icon fill={currentBookmark ? "currentColor" : "none"} name="star" />
                    </Button>
                  </Tooltip>
                </CardHeader>
                <CardContent>
                  {bookmarks.length > 0 ? (
                    <ul className="-my-2 flex flex-col gap-1">
                      {bookmarks.map((bookmark) => {
                        return (
                          <li className="flex items-center justify-between" key={bookmark.uuid}>
                            <Button
                              className="font-normal text-foreground"
                              size="link"
                              variant="link"
                              onClick={() => onOpenChange(false)}
                              render={<Link href={bookmark.url}>{bookmark.name}</Link>}
                            />
                            <div className="flex items-center justify-between gap-1">
                              <Tooltip tooltip={translations["ui.edit"]}>
                                <Button
                                  aria-label={translations["ui.edit"]}
                                  className="size-8"
                                  size="icon"
                                  variant="ghost"
                                  onClick={() => {
                                    setBookmark(bookmark);
                                  }}
                                >
                                  <Icon className="size-4" name="edit" />
                                </Button>
                              </Tooltip>
                              <Tooltip tooltip={translations["ui.remove"]}>
                                <Button
                                  aria-label={translations["ui.remove"]}
                                  className="size-8"
                                  size="icon"
                                  variant="ghost"
                                  onClick={() => {
                                    onDelete(bookmark.uuid);
                                  }}
                                >
                                  <Icon className="size-4" name="star-off" />
                                </Button>
                              </Tooltip>
                            </div>
                          </li>
                        );
                      })}
                    </ul>
                  ) : (
                    <p className="text-muted-foreground">{translations["bookmarks.instruction"]}</p>
                  )}
                </CardContent>
              </CardRoot>
            )}
          </PopoverPopup>
        </PopoverPositioner>
      </PopoverPortal>
    </PopoverRoot>
  );
}

export default Bookmarks;
