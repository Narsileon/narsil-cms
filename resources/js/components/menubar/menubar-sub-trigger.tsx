import { cn } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/icon";
import { Menubar as MenubarPrimitive } from "radix-ui";

type MenubarSubTriggerProps = React.ComponentProps<
  typeof MenubarPrimitive.SubTrigger
> & {
  inset?: boolean;
};

function MenubarSubTrigger({
  children,
  className,
  inset,
  ...props
}: MenubarSubTriggerProps) {
  return (
    <MenubarPrimitive.SubTrigger
      data-slot="menubar-sub-trigger"
      data-inset={inset}
      className={cn(
        "flex cursor-pointer items-center rounded-md px-2 py-1.5 text-sm outline-none select-none",
        "focus:bg-accent focus:text-accent-foreground",
        "data-[state=open]:bg-accent data-[state=open]:text-accent-foreground",
        "data-[inset]:pl-8",
        className,
      )}
      {...props}
    >
      {children}
      <Icon className="ml-auto size-4" name="chevron-right" />
    </MenubarPrimitive.SubTrigger>
  );
}

export default MenubarSubTrigger;
