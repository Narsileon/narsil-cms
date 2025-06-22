import { cn } from "@/lib/utils";
import { Tabs as TabsPrimitive } from "radix-ui";

export type TabsListProps = React.ComponentProps<
  typeof TabsPrimitive.List
> & {};

function TabsList({ className, ...props }: TabsListProps) {
  return (
    <TabsPrimitive.List
      data-slot="tabs-list"
      className={cn(
        "bg-muted text-muted-foreground inline-flex gap-1 p-[3px]",
        "data-[orientation=horizontal]:flex-row data-[orientation=vertical]:flex-col",
        "data-[orientation=horizontal]:h-9 data-[orientation=vertical]:h-fit",
        "data-[orientation=horizontal]:w-fit data-[orientation=vertical]:w-fit",
        "data-[orientation=horizontal]:justify-center data-[orientation=vertical]:items-start",
        "data-[orientation=horizontal]:items-center data-[orientation=vertical]:justify-start",
        "data-[orientation=horizontal]:rounded-lg",
        className,
      )}
      {...props}
    />
  );
}
export default TabsList;
