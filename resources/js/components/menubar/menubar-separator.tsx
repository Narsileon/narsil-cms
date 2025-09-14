import { Menubar } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type MenubarSeparatorProps = React.ComponentProps<
  typeof Menubar.Separator
> & {};

function MenubarSeparator({ className, ...props }: MenubarSeparatorProps) {
  return (
    <Menubar.Separator
      data-slot="menubar-separator"
      className={cn("-mx-1 my-1 h-px bg-border", className)}
      {...props}
    />
  );
}

export default MenubarSeparator;
