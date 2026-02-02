import { Tabs } from "@base-ui/react/tabs";
import { cn } from "@narsil-cms/lib/utils";

function TabsTab({ className, ...props }: Tabs.Tab.Props) {
  return (
    <Tabs.Tab
      data-slot="tabs-trigger"
      className={cn(
        "inline-flex h-9 shrink-0 cursor-pointer items-center gap-2 rounded-md border border-transparent px-3 py-2 whitespace-nowrap text-foreground transition-[color,box-shadow]",
        "disabled:pointer-events-none disabled:opacity-50",
        "focus-visible:border-shine",
        "hover:bg-sidebar-accent hover:text-sidebar-accent-foreground",
        "data-[orientation=horizontal]:justify-center data-[orientation=vertical]:justify-start",
        "data-[orientation=vertical]:w-full",
        "data-active:bg-sidebar-accent",
        "[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4",
        className,
      )}
      {...props}
    />
  );
}

export default TabsTab;
