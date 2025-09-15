import { Link, router } from "@inertiajs/react";
import { sortBy } from "lodash";
import { useEffect, useState } from "react";
import { route } from "ziggy-js";

import { Tooltip } from "@narsil-cms/blocks";
import { ButtonRoot } from "@narsil-cms/components/button";
import {
  Card,
  CardContent,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@narsil-cms/components/card";
import {
  FormFieldRenderer,
  FormProvider,
  FormRoot,
  FormSubmit,
} from "@narsil-cms/components/form";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";
import {
  PopoverContent,
  PopoverRoot,
  PopoverTrigger,
} from "@narsil-cms/components/popover";
import { type Bookmark, type FormType } from "@narsil-cms/types";

type BookmarksProps = React.ComponentProps<typeof PopoverTrigger> & {
  breadcrumb: {
    href: string;
    label: string;
  }[];
};

function Bookmarks({ breadcrumb, ...props }: BookmarksProps) {
  const { trans } = useLabels();

  const [bookmark, setBookmark] = useState<Bookmark | null>(null);
  const [bookmarks, setBookmarks] = useState<Bookmark[]>([]);
  const [form, setForm] = useState<FormType | null>(null);
  const [labels, setLabels] = useState<Record<string, string>>({});
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
      setLabels(data.meta.labels);
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
          <ButtonRoot
            aria-label={trans("bookmarks.tooltip", "Toggle bookmarks menu")}
            size="icon"
            variant="ghost"
          >
            <Icon name="star" fill="currentColor" />
          </ButtonRoot>
        </PopoverTrigger>
      </Tooltip>
      <PopoverContent className="border-none p-0">
        {bookmark && form ? (
          <FormProvider
            action={route("user-bookmarks.update", bookmark.id)}
            id={form.id}
            elements={form.form}
            method="patch"
            initialValues={{
              name: bookmark?.name,
            }}
            render={() => (
              <Card>
                <CardHeader className="border-b">
                  <CardTitle>{form.title}</CardTitle>
                </CardHeader>
                <CardContent>
                  <FormRoot
                    className="grid-cols-12 gap-4"
                    method="patch"
                    options={{
                      onSuccess: () => {
                        fetchBookmarks();
                        setBookmark(null);
                      },
                    }}
                  >
                    {form.form.map((element, index) => (
                      <FormFieldRenderer element={element} key={index} />
                    ))}
                  </FormRoot>
                </CardContent>
                <CardFooter className="justify-between border-t">
                  <ButtonRoot
                    size="sm"
                    variant="secondary"
                    onClick={() => setBookmark(null)}
                  >
                    {labels["ui.cancel"]}
                  </ButtonRoot>
                  <FormSubmit size="sm">{form.submitLabel}</FormSubmit>
                </CardFooter>
              </Card>
            )}
          />
        ) : (
          <Card>
            <CardHeader className="flex items-center justify-between border-b">
              <CardTitle> {labels["bookmarks.bookmarks"]}</CardTitle>
              <Tooltip
                tooltip={
                  currentBookmark ? labels["ui.remove"] : labels["ui.add"]
                }
              >
                <ButtonRoot
                  className="-my-2 size-8"
                  size="icon"
                  variant="ghost"
                  onClick={() => {
                    if (currentBookmark) {
                      onDelete(currentBookmark.id);
                    } else {
                      onAdd();
                    }
                  }}
                >
                  <Icon
                    className="size-4"
                    name={"star"}
                    fill={currentBookmark ? "currentColor" : "none"}
                  />
                </ButtonRoot>
              </Tooltip>
            </CardHeader>
            <CardContent className="text-sm">
              {bookmarks.length > 0 ? (
                <ul className="-my-2 flex flex-col gap-1">
                  {bookmarks.map((bookmark) => (
                    <li
                      className="flex items-center justify-between"
                      key={bookmark.id}
                    >
                      <ButtonRoot
                        className="font-normal text-foreground"
                        size="link"
                        variant="link"
                        onClick={() => onOpenChange(false)}
                      >
                        <Link href={bookmark.url}>{bookmark.name}</Link>
                      </ButtonRoot>
                      <div className="flex items-center justify-between gap-1">
                        <Tooltip tooltip={labels["ui.edit"]}>
                          <ButtonRoot
                            className="size-8"
                            size="icon"
                            variant="ghost"
                            onClick={() => {
                              setBookmark(bookmark);
                            }}
                          >
                            <Icon className="size-4" name="edit" />
                          </ButtonRoot>
                        </Tooltip>
                        <Tooltip tooltip={labels["ui.remove"]}>
                          <ButtonRoot
                            className="size-8"
                            size="icon"
                            variant="ghost"
                            onClick={() => {
                              onDelete(bookmark.id);
                            }}
                          >
                            <Icon className="size-4" name="star-off" />
                          </ButtonRoot>
                        </Tooltip>
                      </div>
                    </li>
                  ))}
                </ul>
              ) : (
                <p className="text-muted-foreground">
                  {labels["bookmarks.instruction"]}
                </p>
              )}
            </CardContent>
          </Card>
        )}
      </PopoverContent>
    </PopoverRoot>
  );
}

export default Bookmarks;
