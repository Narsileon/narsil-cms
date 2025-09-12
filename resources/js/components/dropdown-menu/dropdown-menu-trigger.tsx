import { DropdownMenu as DropdownMenuPrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type DropdownMenuTriggerProps = React.ComponentProps<
  typeof DropdownMenuPrimitive.Trigger
> & {};

function DropdownMenuTrigger({
  className,
  ...props
}: DropdownMenuTriggerProps) {
  return (
    <DropdownMenuPrimitive.Trigger
      data-slot="dropdown-menu-trigger"
      className={cn("cursor-pointer", className)}
      {...props}
    />
  );
}

export default DropdownMenuTrigger;
