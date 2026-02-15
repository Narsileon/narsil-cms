import { Link, router } from "@inertiajs/react";
import { useForm } from "@narsil-cms/components/form";
import { useAlertDialog } from "@narsil-ui/components/alert-dialog";
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
import { Icon } from "@narsil-ui/components/icon";
import { useTranslator } from "@narsil-ui/components/translator";
import type { RoutesData } from "@narsil-ui/types";
import { type ComponentProps } from "react";
import { route } from "ziggy-js";

type FormMenuProps = ComponentProps<typeof Button> & {
  routes?: RoutesData;
};

function FormMenu({ routes, ...props }: FormMenuProps) {
  const { setAlertDialog } = useAlertDialog();
  const { trans } = useTranslator();
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
                        ...routes.parameters,
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
                    ...routes.parameters,
                    id: data.id,
                  });

                  setAlertDialog({
                    title: trans("dialogs.titles.delete"),
                    description: trans("dialogs.descriptions.delete"),
                    actions: [
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
