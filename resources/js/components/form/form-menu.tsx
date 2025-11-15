import { router } from "@inertiajs/react";
import { Button } from "@narsil-cms/blocks";
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
  const { trans } = useLocalization();

  const { data } = useForm();

  function destroy() {
    if (routes?.destroy && data?.id) {
      router.delete(
        route(routes.destroy, {
          ...routes.params,
          id: data.id,
        }),
      );
    }
  }

  return (
    <DropdownMenuRoot>
      <DropdownMenuTrigger asChild={true}>
        <Button icon="more-vertical" size="icon" variant="outline" {...props} />
      </DropdownMenuTrigger>
      <DropdownMenuContent>
        {routes?.destroy && data?.id ? (
          <DropdownMenuItem onClick={destroy}>
            <Icon name="trash" />
            {trans("ui.delete")}
          </DropdownMenuItem>
        ) : null}
      </DropdownMenuContent>
    </DropdownMenuRoot>
  );
}

export default FormMenu;
