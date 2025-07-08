import { cn } from "@/lib/utils";
import { Menubar as MenubarPrimitive } from "radix-ui";

type MenubarSeparatorProps = React.ComponentProps<
  typeof MenubarPrimitive.Separator
> & {};

function MenubarSeparator({ className, ...props }: MenubarSeparatorProps) {
  return (
    <MenubarPrimitive.Separator
      data-slot="menubar-separator"
      className={cn("bg-border -mx-1 my-1 h-px", className)}
      {...props}
    />
  );
}

export default MenubarSeparator;
