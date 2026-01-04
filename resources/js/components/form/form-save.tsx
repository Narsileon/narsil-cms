import { Button } from "@narsil-cms/blocks/button";
import { Kbd } from "@narsil-cms/blocks/kbd";
import { Separator } from "@narsil-cms/blocks/separator";
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

type FormSaveProps = ComponentProps<typeof ButtonGroupRoot> & {
  routes?: RouteNames;
  submitLabel: string;
};

function FormSave({ routes, submitLabel, ...props }: FormSaveProps) {
  const { trans } = useLocalization();
  const { action, data, id, isDirty, method, post, reset, transform } = useForm();

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

  function saveAndPublish() {
    submit(action, method, {
      published: true,
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
          case "KeyD":
            event.preventDefault();

            saveAsNew();
            break;

          case "KeyP":
            event.preventDefault();

            saveAndPublish();
            break;

          case "KeyS":
            event.preventDefault();

            if (event.shiftKey) {
              saveAndAdd();
            } else {
              saveAndContinue();
            }
            break;
        }
      }
    }

    window.addEventListener("keydown", handleKeyDown);
    return () => window.removeEventListener("keydown", handleKeyDown);
  }, [saveAndAdd, saveAndContinue, saveAsNew]);

  return (
    <ButtonGroupRoot {...props}>
      <Button form={id} type="submit">
        {submitLabel}
      </Button>
      <Separator orientation="vertical" />
      <DropdownMenuRoot>
        <DropdownMenuTrigger asChild={true}>
          <Button className="w-8" icon="chevron-down" size="icon" />
        </DropdownMenuTrigger>
        <DropdownMenuContent>
          {routes?.unpublish ? (
            <DropdownMenuItem onClick={saveAndPublish}>
              <Icon name="eye" />
              {`${submitLabel} & ${trans("ui.publish")}`}
              <Kbd className="ml-auto" elements={["Ctrl", "P"]} />
            </DropdownMenuItem>
          ) : null}
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
        </DropdownMenuContent>
      </DropdownMenuRoot>
    </ButtonGroupRoot>
  );
}

export default FormSave;
