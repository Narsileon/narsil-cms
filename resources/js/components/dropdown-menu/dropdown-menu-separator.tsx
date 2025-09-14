import { DropdownMenu } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type DropdownMenuSeparatorProps = React.ComponentProps<
  typeof DropdownMenu.Separator
> & {};

function DropdownMenuSeparator({
  className,
  ...props
}: DropdownMenuSeparatorProps) {
  return (
    <DropdownMenu.Separator
      data-slot="dropdown-menu-separator"
      className={cn("-mx-1 my-1 h-px bg-border", className)}
      {...props}
    />
  );
}

export default DropdownMenuSeparator;
