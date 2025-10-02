import { Tabs } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type TabsListProps = ComponentProps<typeof Tabs.List> & {};

function TabsList({ className, ...props }: TabsListProps) {
  return (
    <Tabs.List
      data-slot="tabs-list"
      className={cn(
        "bg-sidebar text-sidebar-foreground inline-flex gap-1 rounded-xl",
        "data-[orientation=horizontal]:border data-[orientation=vertical]:border-r",
        "data-[orientation=horizontal]:flex-row data-[orientation=vertical]:flex-col",
        "data-[orientation=horizontal]:h-10",
        "data-[orientation=vertical]:items-start data-[orientation=horizontal]:items-center",
        "data-[orientation=vertical]:justify-start data-[orientation=horizontal]:justify-center",
        "data-[orientation=horizontal]:overflow-x-auto data-[orientation=vertical]:overflow-y-auto",
        "data-[orientation=horizontal]:p-1 data-[orientation=vertical]:p-2",
        "data-[orientation=horizontal]:w-full data-[orientation=vertical]:min-w-40",
        "data-[orientation=vertical]:rounded-none",
        className,
      )}
      {...props}
    />
  );
}
export default TabsList;
