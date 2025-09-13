import { Tabs } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type TabsListProps = React.ComponentProps<typeof Tabs.List> & {};

function TabsList({ className, ...props }: TabsListProps) {
  return (
    <Tabs.List
      data-slot="tabs-list"
      className={cn(
        "inline-flex w-fit gap-1 rounded-md bg-sidebar text-sidebar-foreground",
        "data-[orientation=horizontal]:flex-row data-[orientation=vertical]:flex-col",
        "data-[orientation=horizontal]:h-10",
        "data-[orientation=horizontal]:items-center data-[orientation=vertical]:justify-start",
        "data-[orientation=horizontal]:justify-center data-[orientation=vertical]:items-start",
        "data-[orientation=horizontal]:p-1 data-[orientation=vertical]:p-2",
        "data-[orientation=horizontal]:border data-[orientation=vertical]:rounded-none",
        "data-[orientation=horizontal]:overflow-x-auto data-[orientation=vertical]:overflow-y-auto",
        className,
      )}
      {...props}
    />
  );
}
export default TabsList;
