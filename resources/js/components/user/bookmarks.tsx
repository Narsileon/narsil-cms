import * as React from "react";
import { Button } from "@narsil-cms/components/ui/button";
import { Icon } from "@narsil-cms/components/ui/icon";
import { route } from "ziggy-js";
import { Link, router } from "@inertiajs/react";
import { sortBy } from "lodash";
import { Tooltip } from "@narsil-cms/components/ui/tooltip";
import { useLabels } from "@narsil-cms/components/ui/labels";
import axios from "axios";
import {
  Card,
  CardContent,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@narsil-cms/components/ui/card";
import {
  Form,
  FormFieldRenderer,
  FormProvider,
  FormSubmit,
} from "@narsil-cms/components/ui/form";
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from "@narsil-cms/components/ui/popover";
import type { FormType } from "@narsil-cms/types/forms";
import type { UserBookmark } from "@narsil-cms/types/collection";

type UserBookmarksProps = React.ComponentProps<typeof PopoverTrigger> & {
  breadcrumb: {
    href: string;
    label: string;
  }[];
  title: string;
};

function UserBookmarks({ breadcrumb, title, ...props }: UserBookmarksProps) {
  const { trans } = useLabels();

  const [bookmark, setBookmark] = React.useState<UserBookmark | null>(null);
  const [bookmarks, setBookmarks] = React.useState<UserBookmark[]>([]);
  const [form, setForm] = React.useState<FormType | null>(null);
  const [labels, setLabels] = React.useState<Record<string, string>>({});
  const [open, onOpenChange] = React.useState<boolean>(false);

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
        onSuccess: () => {
          fetchBookmarks();
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

  function fetchBookmarks() {
    axios
      .get(route("user-bookmarks.index"))
      .then((response) => {
        console.log(response);
        setBookmarks(sortBy(response.data.data, "name"));
        setForm(response.data.meta.form);
        setLabels(response.data.meta.labels);
      })
      .catch((error) => {
        console.error(error);
      });
  }

  React.useEffect(() => {
    if (!open) {
      return;
    }

    fetchBookmarks();
  }, [open]);

  return (
    <Popover open={open} onOpenChange={onOpenChange}>
      <Tooltip tooltip={trans("bookmarks.tooltip")}>
        <PopoverTrigger asChild={true} {...props}>
          <Button
            aria-label={trans("bookmarks.tooltip", "Toggle bookmarks menu")}
            size="icon"
            variant="ghost"
          >
            <Icon name="star" fill="currentColor" />
          </Button>
        </PopoverTrigger>
      </Tooltip>
      <PopoverContent className="border-none p-0">
        {bookmark && form ? (
          <FormProvider
            id={form.id}
            elements={form.form}
            initialValues={{
              name: bookmark?.name,
            }}
            render={() => (
              <Card>
                <CardHeader className="border-b">
                  <CardTitle>{form.title}</CardTitle>
                </CardHeader>
                <CardContent>
                  <Form
                    className="grid-cols-12 gap-4"
                    method="patch"
                    options={{
                      onSuccess: () => {
                        fetchBookmarks();
                        setBookmark(null);
                      },
                    }}
                    url={route("user-bookmarks.update", bookmark.id)}
                  >
                    {form.form.map((element, index) => (
                      <FormFieldRenderer element={element} key={index} />
                    ))}
                  </Form>
                </CardContent>
                <CardFooter className="justify-between border-t">
                  <Button
                    size="sm"
                    variant="secondary"
                    onClick={() => setBookmark(null)}
                  >
                    {labels["ui.cancel"]}
                  </Button>
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
                <Button
                  className="-my-2 size-8"
                  size="icon"
                  variant="ghost"
                  onClick={() => {
                    currentBookmark ? onDelete(currentBookmark.id) : onAdd();
                  }}
                >
                  <Icon
                    className="size-4"
                    name={"star"}
                    fill={currentBookmark ? "currentColor" : "none"}
                  />
                </Button>
              </Tooltip>
            </CardHeader>
            <CardContent className="text-sm">
              {bookmarks.length > 0 ? (
                <ul className="flex flex-col gap-1">
                  {bookmarks.map((bookmark) => (
                    <li
                      className="flex items-center justify-between"
                      key={bookmark.id}
                    >
                      <Button
                        className="text-foreground font-normal"
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
            </CardContent>
          </Card>
        )}
      </PopoverContent>
    </Popover>
  );
}

export default UserBookmarks;
