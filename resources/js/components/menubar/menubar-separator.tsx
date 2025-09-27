import { Menubar } from "radix-ui";
import { type ComponentProps } from "react";

import { separatorRootVariants } from "@narsil-cms/components/separator";
import { cn } from "@narsil-cms/lib/utils";

type MenubarSeparatorProps = ComponentProps<typeof Menubar.Separator> & {};

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
