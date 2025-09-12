import { Menubar as MenubarPrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type MenubarLabelProps = React.ComponentProps<typeof MenubarPrimitive.Label> & {
  inset?: boolean;
};

function MenubarLabel({ className, inset, ...props }: MenubarLabelProps) {
  return (
    <MenubarPrimitive.Label
      data-slot="menubar-label"
      data-inset={inset}
      className={cn(
        "px-2 py-1.5 text-sm font-medium",
        "data-[inset]:pl-8",
        className,
      )}
      {...props}
    />
  );
}

export default MenubarLabel;
