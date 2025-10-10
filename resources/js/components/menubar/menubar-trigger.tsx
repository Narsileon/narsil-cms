import { cn } from "@narsil-cms/lib/utils";
import { Menubar } from "radix-ui";
import { type ComponentProps } from "react";

type MenubarTriggerProps = ComponentProps<typeof Menubar.Trigger>;

function MenubarTrigger({ className, ...props }: MenubarTriggerProps) {
  return (
    <Menubar.Trigger
      data-slot="menubar-trigger"
      className={cn(
        "outline-hidden flex select-none items-center rounded-md px-2 py-1 font-medium",
        "focus:bg-accent focus:text-accent-foreground",
        "data-[state=open]:bg-accent data-[state=open]:text-accent-foreground",
        className,
      )}
      {...props}
    />
  );
}

export default MenubarTrigger;
