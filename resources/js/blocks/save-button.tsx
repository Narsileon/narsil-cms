import * as React from "react";
import { Button } from "@narsil-cms/components/button";
import { cn } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/icon";
import { Separator } from "@narsil-cms/components/separator";
import { useLabels } from "@narsil-cms/components/labels";
import { useForm } from "@narsil-cms/components/form";
import {
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuRoot,
  DropdownMenuSeparator,
  DropdownMenuShortcut,
  DropdownMenuTrigger,
} from "@narsil-cms/components/dropdown-menu";

type SaveButtonProps = React.ComponentProps<"div"> & {
  submitLabel: string;
};

function SaveButton({ className, submitLabel, ...props }: SaveButtonProps) {
  const { action, id, isDirty, method, post, transform } = useForm();
  const { trans } = useLabels();

  function saveAndAdd() {
    submit();
  }

  function saveAndContinue() {
    submit({
      _back: true,
    });
  }

  function submit(submitData?: Record<string, any>) {
    switch (method) {
      case "patch":
      case "put":
        transform?.((data) => {
          console.log(data);

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
        post?.(action);
        break;
    }
  }

  React.useEffect(() => {
    function handleKeyDown(event: KeyboardEvent) {
      if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === "s") {
        event.preventDefault();

        if (event.shiftKey) {
          saveAndAdd();
        } else {
          saveAndContinue();
        }
      }
    }

    window.addEventListener("keydown", handleKeyDown);

    return () => window.removeEventListener("keydown", handleKeyDown);
  }, [saveAndAdd, saveAndContinue]);

  return (
    <div
      className={cn("flex items-center justify-center", className)}
      {...props}
    >
      <Button className="rounded-r-none" form={id}>
        <Icon name="save" />
        {submitLabel}
      </Button>
      <Separator orientation="vertical" />
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
          <DropdownMenuItem>
            <Icon name="save-and-add" />
            {`${submitLabel} & ${trans("ui.add_another")}`}
            <DropdownMenuShortcut>Ctrl+Shift+S</DropdownMenuShortcut>
          </DropdownMenuItem>
          <DropdownMenuSeparator />
          <DropdownMenuItem>
            <Icon name="plus" />
            {trans("ui.save_as_new")}
          </DropdownMenuItem>
        </DropdownMenuContent>
      </DropdownMenuRoot>
    </div>
  );
}

export default SaveButton;
