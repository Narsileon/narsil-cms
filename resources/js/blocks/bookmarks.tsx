import { Link, router } from "@inertiajs/react";
import { sortBy } from "lodash";
import { useEffect, useState } from "react";
import { route } from "ziggy-js";

import { Button, Card, Tooltip } from "@narsil-cms/blocks";
import {
  FormFieldRenderer,
  FormProvider,
  FormRoot,
} from "@narsil-cms/components/form";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";
import {
  PopoverContent,
  PopoverPortal,
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
          <Button
            aria-label={trans("bookmarks.tooltip", "Toggle bookmarks menu")}
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
              elements={form.form}
              method="patch"
              initialValues={{
                name: bookmark?.name,
              }}
              render={() => (
                <Card
                  footerButtons={[
                    {
                      label: labels["ui.cancel"],
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
                </Card>
              )}
            />
          ) : (
            <Card
              contentProps={{
                className: "text-sm",
              }}
              headerButtons={[
                {
                  className: "-my-2 size-8",
                  iconProps: {
                    fill: currentBookmark ? "currentColor" : "none",
                    name: "star",
                  },
                  size: "icon",
                  tooltip: currentBookmark
                    ? labels["ui.remove"]
                    : labels["ui.add"],
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
              title={labels["bookmarks.bookmarks"]}
            >
              {bookmarks.length > 0 ? (
                <ul className="-my-2 flex flex-col gap-1">
                  {bookmarks.map((bookmark) => (
                    <li
                      className="flex items-center justify-between"
                      key={bookmark.id}
                    >
                      <Button
                        className="font-normal text-foreground"
                        size="link"
                        variant="link"
                        onClick={() => onOpenChange(false)}
                      >
                        <Link href={bookmark.url}>{bookmark.name}</Link>
                      </Button>
                      <div className="flex items-center justify-between gap-1">
                        <Tooltip tooltip={labels["ui.edit"]}>
                          <Button
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
                        <Tooltip tooltip={labels["ui.remove"]}>
                          <Button
                            className="size-8"
                            size="icon"
                            variant="ghost"
                            onClick={() => {
                              onDelete(bookmark.id);
                            }}
                          >
                            <Icon className="size-4" name="star-off" />
                          </Button>
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
            </Card>
          )}
        </PopoverContent>
      </PopoverPortal>
    </PopoverRoot>
  );
}

export default Bookmarks;
