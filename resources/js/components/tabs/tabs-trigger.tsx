import { Tabs } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type TabsTriggerProps = React.ComponentProps<typeof Tabs.Trigger> & {};

function TabsTrigger({ className, ...props }: TabsTriggerProps) {
  return (
    <Tabs.Trigger
      data-slot="tabs-trigger"
      className={cn(
        "inline-flex cursor-pointer items-center gap-1.5 rounded-md border border-transparent px-2 py-1 whitespace-nowrap text-foreground transition-[color,box-shadow]",
        "disabled:pointer-events-none disabled:opacity-50",
        "focus-visible:border-ring focus-visible:ring-2 focus-visible:ring-ring/50 focus-visible:outline-1 focus-visible:outline-ring",
        "hover:bg-sidebar-accent hover:text-sidebar-accent-foreground",
        "data-[orientation=horizontal]:flex-1",
        "data-[orientation=horizontal]:h-7 data-[orientation=vertical]:h-9",
        "data-[orientation=horizontal]:justify-center data-[orientation=vertical]:justify-start",
        "data-[orientation=vertical]:w-full",
        "data-[state=active]:bg-sidebar-accent",
        "[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4",
        className,
      )}
      {...props}
    />
  );
}

export default TabsTrigger;
