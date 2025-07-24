import { cn } from "@narsil-cms/lib/utils";
import { Tabs as TabsPrimitive } from "radix-ui";

type TabsTriggerProps = React.ComponentProps<typeof TabsPrimitive.Trigger> & {};

function TabsTrigger({ className, ...props }: TabsTriggerProps) {
  return (
    <TabsPrimitive.Trigger
      data-slot="tabs-trigger"
      className={cn(
        "text-foreground inline-flex items-center gap-1.5 rounded-md border border-transparent px-2 py-1 text-sm font-medium whitespace-nowrap transition-[color,box-shadow]",
        "disabled:pointer-events-none disabled:opacity-50",
        "dark:text-muted-foreground",
        "dark:data-[state=active]:text-foreground dark:data-[state=active]:border-input dark:data-[state=active]:bg-input/30",
        "focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:outline-ring focus-visible:ring-[3px] focus-visible:outline-1",
        "data-[orientation=horizontal]:flex-1",
        "data-[orientation=horizontal]:h-[calc(100%-1px)] data-[orientation=vertical]:h-9",
        "data-[orientation=horizontal]:justify-center data-[orientation=vertical]:justify-start",
        "data-[orientation=vertical]:w-full",
        "data-[state=active]:bg-background",
        "data-[state=active]:shadow-sm",
        "[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4",
        className,
      )}
      {...props}
    />
  );
}

export default TabsTrigger;
