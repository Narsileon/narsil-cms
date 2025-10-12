import { cn } from "@narsil-cms/lib/utils";
import { DropdownMenu } from "radix-ui";
import { type ComponentProps } from "react";

type DropdownMenuTriggerProps = ComponentProps<typeof DropdownMenu.Trigger>;

function DropdownMenuTrigger({ className, ...props }: DropdownMenuTriggerProps) {
  return (
    <DropdownMenu.Trigger
      data-slot="dropdown-menu-trigger"
      className={cn("cursor-pointer", className)}
      {...props}
    />
  );
}

export default DropdownMenuTrigger;
