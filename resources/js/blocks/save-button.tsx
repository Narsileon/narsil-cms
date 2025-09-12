import { router } from "@inertiajs/react";
import { useEffect } from "react";
import { route } from "ziggy-js";

import { Button } from "@narsil-cms/components/button";
import {
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuRoot,
  DropdownMenuSeparator,
  DropdownMenuShortcut,
  DropdownMenuTrigger,
} from "@narsil-cms/components/dropdown-menu";
import { useForm } from "@narsil-cms/components/form";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";
import { SeparatorRoot } from "@narsil-cms/components/separator";
import { cn } from "@narsil-cms/lib/utils";
import { type RouteNames } from "@narsil-cms/types";

type SaveButtonProps = React.ComponentProps<"div"> & {
  routes?: RouteNames;
  submitLabel: string;
};

function SaveButton({
  className,
  routes,
  submitLabel,
  ...props
}: SaveButtonProps) {
  const { trans } = useLabels();

  const { action, data, id, isDirty, method, post, reset, transform } =
    useForm();

  function destroy() {
    if (routes?.destroy && data?.id) {
      router.delete(route(routes.destroy, { id: data.id }));
    }
  }

  function saveAndAdd() {
    if (routes?.create) {
      submit(action, method, {
        _to: route(routes.create),
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
      submit(route(routes.store), "post");
    }
  }

  function submit(
    action: string,
    method: string,
    submitData?: Record<string, unknown>,
  ) {
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
    <div
      className={cn("flex items-center justify-center", className)}
      {...props}
    >
      <Button className="rounded-r-none" form={id} type="submit">
        <Icon name="save" />
        {submitLabel}
      </Button>
      <SeparatorRoot orientation="vertical" />
      <DropdownMenuRoot>
        <DropdownMenuTrigger asChild={true}>
          <Button className="w-7 rounded-l-none" size="icon">
            <Icon name="chevron-down" />
          </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent>
          <DropdownMenuItem onClick={saveAndContinue}>
            <Icon name="save-and-continue" />
            {`${submitLabel} & ${trans("ui.continue")}`}
            <DropdownMenuShortcut>Ctrl+S</DropdownMenuShortcut>
          </DropdownMenuItem>
          {routes?.create ? (
            <DropdownMenuItem onClick={saveAndAdd}>
              <Icon name="save-and-add" />
              {`${submitLabel} & ${trans("ui.add_another")}`}
              <DropdownMenuShortcut>Ctrl+Shift+S</DropdownMenuShortcut>
            </DropdownMenuItem>
          ) : null}
          {routes?.store && data?.id ? (
            <>
              <DropdownMenuSeparator />
              <DropdownMenuItem onClick={saveAsNew}>
                <Icon name="plus" />
                {trans("ui.save_as_new")}
                <DropdownMenuShortcut>Ctrl+D</DropdownMenuShortcut>
              </DropdownMenuItem>
            </>
          ) : null}
          {routes?.destroy && data?.id ? (
            <>
              <DropdownMenuSeparator />
              <DropdownMenuItem onClick={destroy}>
                <Icon name="trash" />
                {trans("ui.delete")}
                <DropdownMenuShortcut>Ctrl+X</DropdownMenuShortcut>
              </DropdownMenuItem>
            </>
          ) : null}
        </DropdownMenuContent>
      </DropdownMenuRoot>
    </div>
  );
}

export default SaveButton;
