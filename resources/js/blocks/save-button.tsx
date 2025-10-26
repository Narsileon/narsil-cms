import { router } from "@inertiajs/react";
import { Button, Kbd, Separator } from "@narsil-cms/blocks";
import { ButtonGroupRoot } from "@narsil-cms/components/button-group";
import {
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuRoot,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@narsil-cms/components/dropdown-menu";
import { useForm } from "@narsil-cms/components/form";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import type { RouteNames } from "@narsil-cms/types";
import { useEffect, type ComponentProps } from "react";
import { route } from "ziggy-js";

type SaveButtonProps = ComponentProps<typeof ButtonGroupRoot> & {
  routes?: RouteNames;
  submitLabel: string;
};

function SaveButton({ routes, submitLabel, ...props }: SaveButtonProps) {
  const { trans } = useLocalization();
  const { action, data, id, isDirty, method, post, reset, transform } = useForm();

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

  function saveAndAdd() {
    if (routes?.create) {
      submit(action, method, {
        _to: route(routes.create, routes.params),
      });
    }
  }

  function saveAndContinue() {
    submit(action, method, {
      _back: true,
    });
  }

  function saveAsNew() {
    if (routes?.store) {
      submit(route(routes.store, routes.params), "post");
    }
  }

  function submit(action: string, method: string, submitData?: Record<string, unknown>) {
    switch (method) {
      case "patch":
      case "put":
        transform?.((data) => {
          return {
            ...data,
            ...submitData,
            _dirty: isDirty,
            _method: method,
          };
        });

        post?.(action, { forceFormData: true });
        break;
      case "post":
        transform?.((data) => {
          return {
            ...data,
            ...submitData,
            _dirty: isDirty,
          };
        });

        post?.(action);

        reset?.();

        break;
    }
  }

  useEffect(() => {
    function handleKeyDown(event: KeyboardEvent) {
      if (event.ctrlKey || event.metaKey) {
        switch (event.code) {
          case "KeyS":
            event.preventDefault();
            if (event.shiftKey) {
              saveAndAdd();
            } else {
              saveAndContinue();
            }
            break;

          case "KeyD":
            event.preventDefault();
            saveAsNew();
            break;
          case "KeyX":
            event.preventDefault();
            destroy();
            break;
        }
      }
    }

    window.addEventListener("keydown", handleKeyDown);
    return () => window.removeEventListener("keydown", handleKeyDown);
  }, [saveAndAdd, saveAndContinue, saveAsNew]);

  return (
    <ButtonGroupRoot {...props}>
      <Button form={id} icon="save" type="submit">
        {submitLabel}
      </Button>
      <Separator orientation="vertical" />
      <DropdownMenuRoot>
        <DropdownMenuTrigger asChild={true}>
          <Button className="w-7" icon="chevron-down" size="icon" />
        </DropdownMenuTrigger>
        <DropdownMenuContent>
          <DropdownMenuItem onClick={saveAndContinue}>
            <Icon name="save-and-continue" />
            {`${submitLabel} & ${trans("ui.continue")}`}
            <Kbd className="ml-auto" elements={["Ctrl", "S"]} />
          </DropdownMenuItem>
          {routes?.create ? (
            <DropdownMenuItem onClick={saveAndAdd}>
              <Icon name="save-and-add" />
              {`${submitLabel} & ${trans("ui.add_another")}`}
              <Kbd className="ml-auto" elements={["Ctrl", "Shift", "S"]} />
            </DropdownMenuItem>
          ) : null}
          {routes?.store && data?.id ? (
            <>
              <DropdownMenuSeparator />
              <DropdownMenuItem onClick={saveAsNew}>
                <Icon name="plus" />
                {trans("ui.save_as_new")}
                <Kbd className="ml-auto" elements={["Ctrl", "D"]} />
              </DropdownMenuItem>
            </>
          ) : null}
          {routes?.destroy && data?.id ? (
            <>
              <DropdownMenuSeparator />
              <DropdownMenuItem onClick={destroy}>
                <Icon name="trash" />
                {trans("ui.delete")}
                <Kbd className="ml-auto" elements={["Ctrl", "X"]} />
              </DropdownMenuItem>
            </>
          ) : null}
        </DropdownMenuContent>
      </DropdownMenuRoot>
    </ButtonGroupRoot>
  );
}

export default SaveButton;
