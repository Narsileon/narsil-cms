import * as React from "react";
import { Button } from "@narsil-cms/components/ui/button";
import { cn } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/ui/icon";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuShortcut,
  DropdownMenuTrigger,
} from "@narsil-cms/components/ui/dropdown-menu";

type SaveButtonProps = React.ComponentProps<"div"> & {
  form: string;
  submitLabel: string;
};

function SaveButton({
  className,
  form,
  submitLabel,
  ...props
}: SaveButtonProps) {
  return (
    <div
      className={cn("flex items-center justify-center", className)}
      {...props}
    >
      <Button form={form} type="submit">
        {submitLabel}
      </Button>
      <DropdownMenu>
        <DropdownMenuTrigger asChild={true}>
          <Button size="icon">
            <Icon name="chevron-down" />
          </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent>
          <DropdownMenuItem>
            Save & Continue editing
            <DropdownMenuShortcut>Ctrl+S</DropdownMenuShortcut>
          </DropdownMenuItem>
          <DropdownMenuItem>
            Save & add another
            <DropdownMenuShortcut>Ctrl+Shift+S</DropdownMenuShortcut>
          </DropdownMenuItem>
          <DropdownMenuItem>Save as new</DropdownMenuItem>
        </DropdownMenuContent>
      </DropdownMenu>
    </div>
  );
}

export default SaveButton;
