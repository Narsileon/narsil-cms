import { router } from "@inertiajs/react";
import { Button } from "@narsil-cms/blocks";
import { useAlertDialog } from "@narsil-cms/components/alert-dialog";
import {
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuRoot,
  DropdownMenuTrigger,
} from "@narsil-cms/components/dropdown-menu";
import { useForm } from "@narsil-cms/components/form";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import type { RouteNames } from "@narsil-cms/types";
import { type ComponentProps } from "react";
import { route } from "ziggy-js";

type FormMenuProps = ComponentProps<typeof Button> & {
  routes?: RouteNames;
};

function FormMenu({ routes, ...props }: FormMenuProps) {
  const { setOpen } = useAlertDialog();
  const { trans } = useLocalization();
  const { data } = useForm();

  return (
    <DropdownMenuRoot>
      <DropdownMenuTrigger asChild={true}>
        <Button icon="more-vertical" size="icon" variant="outline" {...props} />
      </DropdownMenuTrigger>
      <DropdownMenuContent>
        {routes?.destroy && data?.id ? (
          <DropdownMenuItem
            onClick={() => {
              const href = route(routes.destroy as string, {
                ...routes.params,
                id: data.id,
              });

              setOpen({
                title: trans("dialogs.titles.delete"),
                description: trans("dialogs.descriptions.delete"),
                actionClick: () => {
                  router.delete(href);
                },
              });
            }}
          >
            <Icon name="trash" />
            {trans("ui.delete")}
          </DropdownMenuItem>
        ) : null}
      </DropdownMenuContent>
    </DropdownMenuRoot>
  );
}

export default FormMenu;
