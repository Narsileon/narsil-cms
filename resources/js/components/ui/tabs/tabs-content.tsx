import { cn } from "@/lib/utils";
import { Tabs as TabsPrimitive } from "radix-ui";

export type TabsContentProps = React.ComponentProps<
  typeof TabsPrimitive.Content
> & {};

function TabsContent({ className, ...props }: TabsContentProps) {
  return (
    <TabsPrimitive.Content
      data-slot="tabs-content"
      className={cn(
        "flex-1 outline-none",
        "data-[orientation=vertical]:px-4",
        className,
      )}
      {...props}
    />
  );
}

export default TabsContent;
