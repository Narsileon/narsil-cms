import { DropdownMenu } from "radix-ui";
import { type ComponentProps } from "react";

import { separatorRootVariants } from "@narsil-cms/components/separator";
import { cn } from "@narsil-cms/lib/utils";

type DropdownMenuSeparatorProps = ComponentProps<
  typeof DropdownMenu.Separator
> & {};

function DropdownMenuSeparator({
  className,
  ...props
}: DropdownMenuSeparatorProps) {
  return (
    <DropdownMenu.Separator
      data-slot="dropdown-menu-separator"
      className={cn(separatorRootVariants({ variant: "menu" }), className)}
      {...props}
    />
  );
}

export default DropdownMenuSeparator;
