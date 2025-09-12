import { cn } from "@narsil-cms/lib/utils";
import { Menubar as MenubarPrimitive } from "radix-ui";

type MenubarSeparatorProps = React.ComponentProps<
  typeof MenubarPrimitive.Separator
> & {};

function MenubarSeparator({ className, ...props }: MenubarSeparatorProps) {
  return (
    <MenubarPrimitive.Separator
      data-slot="menubar-separator"
      className={cn("-mx-1 my-1 h-px bg-border", className)}
      {...props}
    />
  );
}

export default MenubarSeparator;
