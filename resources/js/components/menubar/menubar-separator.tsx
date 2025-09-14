import { Menubar } from "radix-ui";

import { separatorRootVariants } from "@narsil-cms/components/separator";
import { cn } from "@narsil-cms/lib/utils";

type MenubarSeparatorProps = React.ComponentProps<
  typeof Menubar.Separator
> & {};

function MenubarSeparator({ className, ...props }: MenubarSeparatorProps) {
  return (
    <Menubar.Separator
      data-slot="menubar-separator"
      className={cn(separatorRootVariants({ variant: "menu" }), className)}
      {...props}
    />
  );
}

export default MenubarSeparator;
