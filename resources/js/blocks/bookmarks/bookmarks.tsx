import { Link, router } from "@inertiajs/react";
import type { Bookmark } from "@narsil-cms/types";
import { Button } from "@narsil-ui/components/button";
import {
  CardContent,
  CardFooter,
  CardHeader,
  CardRoot,
  CardTitle,
} from "@narsil-ui/components/card";
import { FormElement, FormProvider, FormRoot, registry } from "@narsil-ui/components/form";
import { Icon } from "@narsil-ui/components/icon";
import {
  PopoverPopup,
  PopoverPortal,
  PopoverPositioner,
  PopoverRoot,
  PopoverTrigger,
} from "@narsil-ui/components/popover";
import { Tooltip } from "@narsil-ui/components/tooltip";
import { useTranslator } from "@narsil-ui/components/translator";
import type { FormData } from "@narsil-ui/types";
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
  const { trans } = useTranslator();

  const [bookmark, setBookmark] = useState<Bookmark | null>(null);
  const [bookmarks, setBookmarks] = useState<Bookmark[]>([]);
  const [form, setForm] = useState<FormData | null>(null);
  const [open, onOpenChange] = useState<boolean>(false);
  const [translations, setTranslations] = useState<Record<string, string>>({});

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
                id={form.id}
                action={route("user-bookmarks.update", bookmark.uuid)}
                method="patch"
                steps={form.steps}
                initialData={{
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
                          {form.steps.map((step, index) => {
                            return (
                              <Fragment key={index}>
                                {step.elements?.map((element, index) => {
                                  return (
                                    <FormElement {...element} registry={registry} key={index} />
                                  );
                                })}
                              </Fragment>
                            );
                          })}
                        </FormRoot>
                      </CardContent>
                      <CardFooter className="justify-between border-t">
                        <Button variant="secondary" onClick={() => setBookmark(null)}>
                          {translations["ui.cancel"]}
                        </Button>
                        <Button form={form.id} type="submit">
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
                                  size="icon-sm"
                                  variant="ghost"
                                  onClick={() => {
                                    setBookmark(bookmark);
                                  }}
                                >
                                  <Icon name="edit" />
                                </Button>
                              </Tooltip>
                              <Tooltip tooltip={translations["ui.remove"]}>
                                <Button
                                  aria-label={translations["ui.remove"]}
                                  size="icon-sm"
                                  variant="ghost"
                                  onClick={() => {
                                    onDelete(bookmark.uuid);
                                  }}
                                >
                                  <Icon name="star-off" />
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
