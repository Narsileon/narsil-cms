import { Menubar } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type MenubarTriggerProps = React.ComponentProps<typeof Menubar.Trigger> & {};

function MenubarTrigger({ className, ...props }: MenubarTriggerProps) {
  return (
    <Menubar.Trigger
      data-slot="menubar-trigger"
      className={cn(
        "flex items-center rounded-md px-2 py-1 font-medium outline-hidden select-none",
        "focus:bg-accent focus:text-accent-foreground",
        "data-[state=open]:bg-accent data-[state=open]:text-accent-foreground",
        className,
      )}
      {...props}
    />
  );
}

export default MenubarTrigger;
