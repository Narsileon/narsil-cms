import { Tabs } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type TabsTriggerProps = ComponentProps<typeof Tabs.Trigger> & {};

function TabsTrigger({ className, ...props }: TabsTriggerProps) {
  return (
    <Tabs.Trigger
      data-slot="tabs-trigger"
      className={cn(
        "text-foreground inline-flex cursor-pointer items-center gap-1.5 whitespace-nowrap rounded-md border border-transparent px-2 py-1 transition-[color,box-shadow]",
        "disabled:pointer-events-none disabled:opacity-50",
        "focus-visible:border-shine",
        "hover:bg-sidebar-accent hover:text-sidebar-accent-foreground",
        "data-[orientation=horizontal]:flex-1",
        "data-[orientation=horizontal]:h-7 data-[orientation=vertical]:h-9",
        "data-[orientation=vertical]:justify-start data-[orientation=horizontal]:justify-center",
        "data-[orientation=vertical]:w-full",
        "data-[state=active]:bg-sidebar-accent",
        "[&_svg:not([class*='size-'])]:size-4 [&_svg]:pointer-events-none [&_svg]:shrink-0",
        className,
      )}
      {...props}
    />
  );
}

export default TabsTrigger;
