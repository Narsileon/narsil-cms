import { Link, router } from "@inertiajs/react";
import { Icon } from "@narsil-cms/blocks/icon";
import { useAlertDialog } from "@narsil-cms/components/alert-dialog";
import { Button } from "@narsil-cms/components/button";
import {
  DropdownMenuItem,
  DropdownMenuPopup,
  DropdownMenuPortal,
  DropdownMenuPositioner,
  DropdownMenuRoot,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@narsil-cms/components/dropdown-menu";
import { useForm } from "@narsil-cms/components/form";
import { useLocalization } from "@narsil-cms/components/localization";
import type { RouteNames } from "@narsil-cms/types";
import { type ComponentProps } from "react";
import { route } from "ziggy-js";

type FormMenuProps = ComponentProps<typeof Button> & {
  routes?: RouteNames;
};

function FormMenu({ routes, ...props }: FormMenuProps) {
  const { setAlertDialog } = useAlertDialog();
  const { trans } = useLocalization();
  const { data } = useForm();

  return (
    <DropdownMenuRoot>
      <DropdownMenuTrigger
        render={
          <Button size="icon" variant="outline" {...props}>
            <Icon name="more-vertical" />
          </Button>
        }
      />
      <DropdownMenuPortal>
        <DropdownMenuPositioner>
          <DropdownMenuPopup>
            {routes?.unpublish && data?.id ? (
              <>
                <DropdownMenuItem
                  render={
                    <Link
                      as="button"
                      href={route(routes.unpublish, {
                        ...routes.params,
                        id: data?.id,
                      })}
                      method="post"
                    >
                      <Icon name="eye-off" />
                      {trans("ui.unpublish")}
                    </Link>
                  }
                />
                <DropdownMenuSeparator />
              </>
            ) : null}
            {routes?.destroy && data?.id ? (
              <DropdownMenuItem
                onClick={() => {
                  const href = route(routes.destroy as string, {
                    ...routes.params,
                    id: data.id,
                  });

                  setAlertDialog({
                    title: trans("dialogs.titles.delete"),
                    description: trans("dialogs.descriptions.delete"),
                    buttons: [
                      {
                        onClick: () => {
                          router.delete(href);
                        },
                      },
                    ],
                  });
                }}
              >
                <Icon name="trash" />
                {trans("ui.delete")}
              </DropdownMenuItem>
            ) : null}
          </DropdownMenuPopup>
        </DropdownMenuPositioner>
      </DropdownMenuPortal>
    </DropdownMenuRoot>
  );
}

export default FormMenu;
