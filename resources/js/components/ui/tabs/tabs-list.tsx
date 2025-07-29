import { cn } from "@narsil-cms/lib/utils";
import { Tabs as TabsPrimitive } from "radix-ui";
import { ScrollArea } from "../scroll-area";

type TabsListProps = React.ComponentProps<typeof TabsPrimitive.List> & {};

function TabsList({ children, className, ...props }: TabsListProps) {
  return (
    <ScrollArea
      className="min-h-10 md:min-w-fit"
      orientation="horizontal"
      asChild={true}
    >
      <TabsPrimitive.List
        data-slot="tabs-list"
        className={cn(
          "bg-sidebar text-sidebar-foreground inline-flex w-fit gap-1 rounded-md",
          "data-[orientation=horizontal]:flex-row data-[orientation=vertical]:flex-col",
          "data-[orientation=horizontal]:h-10 data-[orientation=vertical]:h-full",
          "data-[orientation=horizontal]:items-center data-[orientation=vertical]:justify-start",
          "data-[orientation=horizontal]:justify-center data-[orientation=vertical]:items-start",
          "data-[orientation=horizontal]:p-1 data-[orientation=vertical]:p-2",
          "data-[orientation=horizontal]:border data-[orientation=vertical]:rounded-r-none",
          className,
        )}
        {...props}
      >
        {children}
      </TabsPrimitive.List>
    </ScrollArea>
  );
}
export default TabsList;
