import { useForm } from "@narsil-cms/components/form";
import type { RouteNames } from "@narsil-cms/types";
import { Button } from "@narsil-ui/components/button";
import { ButtonGroup } from "@narsil-ui/components/button-group";
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
import { Kbd, KbdGroup } from "@narsil-ui/components/kbd";
import { Separator } from "@narsil-ui/components/separator";
import { useTranslator } from "@narsil-ui/components/translator";
import { useEffect, type ComponentProps } from "react";
import { route } from "ziggy-js";

type FormSaveProps = ComponentProps<typeof ButtonGroup> & {
  routes?: RouteNames;
  submitLabel: string;
};

function FormSave({ routes, submitLabel, ...props }: FormSaveProps) {
  const { trans } = useTranslator();
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
    <ButtonGroup {...props}>
      <Button form={id} type="submit">
        {submitLabel}
      </Button>
      <Separator orientation="vertical" />
      <DropdownMenuRoot>
        <DropdownMenuTrigger
          render={
            <Button className="w-8" size="icon">
              <Icon name="chevron-down" />
            </Button>
          }
        />
        <DropdownMenuPortal>
          <DropdownMenuPositioner>
            <DropdownMenuPopup>
              {routes?.unpublish ? (
                <DropdownMenuItem onClick={saveAndPublish}>
                  <Icon name="eye" />
                  {`${submitLabel} & ${trans("ui.publish")}`}
                  <KbdGroup className="ml-auto">
                    <Kbd>Ctrl</Kbd>
                    <Kbd>P</Kbd>
                  </KbdGroup>
                </DropdownMenuItem>
              ) : null}
              <DropdownMenuItem onClick={saveAndContinue}>
                <Icon name="save-and-continue" />
                {`${submitLabel} & ${trans("ui.continue")}`}
                <KbdGroup className="ml-auto">
                  <Kbd>Ctrl</Kbd>
                  <Kbd>S</Kbd>
                </KbdGroup>
              </DropdownMenuItem>
              {routes?.create ? (
                <DropdownMenuItem onClick={saveAndAdd}>
                  <Icon name="save-and-add" />
                  {`${submitLabel} & ${trans("ui.add_another")}`}
                  <KbdGroup className="ml-auto">
                    <Kbd>Ctrl</Kbd>
                    <Kbd>Shift</Kbd>
                    <Kbd>S</Kbd>
                  </KbdGroup>
                </DropdownMenuItem>
              ) : null}
              {routes?.store && data?.id ? (
                <>
                  <DropdownMenuSeparator />
                  <DropdownMenuItem onClick={saveAsNew}>
                    <Icon name="plus" />
                    {trans("ui.save_as_new")}
                    <KbdGroup className="ml-auto">
                      <Kbd>Ctrl</Kbd>
                      <Kbd>D</Kbd>
                    </KbdGroup>
                  </DropdownMenuItem>
                </>
              ) : null}
            </DropdownMenuPopup>
          </DropdownMenuPositioner>
        </DropdownMenuPortal>
      </DropdownMenuRoot>
    </ButtonGroup>
  );
}

export default FormSave;
