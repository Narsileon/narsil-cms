import { DropdownMenu } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type DropdownMenuTriggerProps = React.ComponentProps<
  typeof DropdownMenu.Trigger
> & {};

function DropdownMenuTrigger({
  className,
  ...props
}: DropdownMenuTriggerProps) {
  return (
    <DropdownMenu.Trigger
      data-slot="dropdown-menu-trigger"
      className={cn("cursor-pointer", className)}
      {...props}
    />
  );
}

export default DropdownMenuTrigger;
