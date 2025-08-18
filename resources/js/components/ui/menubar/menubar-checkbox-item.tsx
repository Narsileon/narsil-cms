import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/ui/icon";
import { Menubar as MenubarPrimitive } from "radix-ui";

type MenubarCheckboxItemProps = React.ComponentProps<
  typeof MenubarPrimitive.CheckboxItem
> & {};

function MenubarCheckboxItem({
  checked,
  children,
  className,
  ...props
}: MenubarCheckboxItemProps) {
  return (
    <MenubarPrimitive.CheckboxItem
      data-slot="menubar-checkbox-item"
      className={cn(
        "relative flex cursor-pointer items-center gap-2 rounded-md py-1.5 pr-2 pl-8 text-sm outline-hidden select-none",
        "focus:bg-accent focus:text-accent-foreground",
        "data-[disabled]:pointer-events-none data-[disabled]:opacity-50",
        "[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4",
        className,
      )}
      checked={checked}
      {...props}
    >
      <span className="pointer-events-none absolute left-2 flex size-3.5 items-center justify-center">
        <MenubarPrimitive.ItemIndicator>
          <Icon className="size-4" name="check" />
        </MenubarPrimitive.ItemIndicator>
      </span>
      {children}
    </MenubarPrimitive.CheckboxItem>
  );
}

export default MenubarCheckboxItem;
