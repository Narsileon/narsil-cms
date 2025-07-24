import { cn } from "@narsil-cms/lib/utils";
import { Tabs as TabsPrimitive } from "radix-ui";
import { ScrollArea } from "../scroll-area";

type TabsListProps = React.ComponentProps<typeof TabsPrimitive.List> & {};

function TabsList({ children, className, ...props }: TabsListProps) {
  return (
    <ScrollArea
      className="md:min-w-fit"
      orientation="horizontal"
      asChild={true}
    >
      <TabsPrimitive.List
        data-slot="tabs-list"
        className={cn(
          "bg-muted text-muted-foreground inline-flex w-fit gap-1 rounded-lg",
          "data-[orientation=horizontal]:flex-row data-[orientation=vertical]:flex-col",
          "data-[orientation=horizontal]:h-9 data-[orientation=vertical]:h-full",
          "data-[orientation=horizontal]:items-center data-[orientation=vertical]:justify-start",
          "data-[orientation=horizontal]:justify-center data-[orientation=vertical]:items-start",
          "data-[orientation=horizontal]:mb-6",
          "data-[orientation=horizontal]:p-1 data-[orientation=vertical]:p-2",
          "data-[orientation=vertical]:rounded-r-none",
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
