import * as React from "react";
import { Button } from "@narsil-cms/components/ui/button";
import { cn } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/ui/icon";
import { Separator } from "@narsil-cms/components/ui/separator";
import { useLabels } from "@narsil-cms/components/ui/labels";
import { useForm } from "@narsil-cms/components/ui/form";
import {
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuRoot,
  DropdownMenuSeparator,
  DropdownMenuShortcut,
  DropdownMenuTrigger,
} from "@narsil-cms/components/ui/dropdown-menu";

type SaveButtonProps = React.ComponentProps<"div"> & {
  submitLabel: string;
};

function SaveButton({ className, submitLabel, ...props }: SaveButtonProps) {
  const { action, id, isDirty, method, post, transform } = useForm();
  const { trans } = useLabels();

  function saveAndAdd() {
    console.log("save and add");

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
        transform?.((data) => ({
          ...data,
          ...submitData,
          _dirty: isDirty,
          _method: method,
        }));
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
  }, []);

  return (
    <div
      className={cn("flex items-center justify-center", className)}
      {...props}
    >
      <Button className="rounded-r-none" form={id} type="submit">
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
