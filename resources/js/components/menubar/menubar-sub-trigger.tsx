import { Icon } from "@narsil-cms/blocks/icon";
import { cn } from "@narsil-cms/lib/utils";
import { Menubar } from "radix-ui";
import { type ComponentProps } from "react";

type MenubarSubTriggerProps = ComponentProps<typeof Menubar.SubTrigger> & {
  inset?: boolean;
};

function MenubarSubTrigger({ children, className, inset, ...props }: MenubarSubTriggerProps) {
  return (
    <Menubar.SubTrigger
      data-slot="menubar-sub-trigger"
      data-inset={inset}
      className={cn(
        "flex cursor-pointer items-center rounded-md px-2 py-1.5 outline-none select-none",
        "focus:bg-accent focus:text-accent-foreground",
        "data-[state=open]:bg-accent data-[state=open]:text-accent-foreground",
        "data-inset:pl-8",
        className,
      )}
      {...props}
    >
      {children}
      <Icon className="ml-auto size-4" name="chevron-right" />
    </Menubar.SubTrigger>
  );
}

export default MenubarSubTrigger;
