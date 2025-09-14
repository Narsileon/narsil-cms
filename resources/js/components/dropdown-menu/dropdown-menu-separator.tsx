import { DropdownMenu } from "radix-ui";

import { separatorRootVariants } from "@narsil-cms/components/separator";
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
      className={cn(separatorRootVariants({ variant: "menu" }), className)}
      {...props}
    />
  );
}

export default DropdownMenuSeparator;
