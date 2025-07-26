import { cn } from "@narsil-cms/lib/utils";
import { Tabs as TabsPrimitive } from "radix-ui";

type TabsContentProps = React.ComponentProps<typeof TabsPrimitive.Content> & {};

function TabsContent({ className, ...props }: TabsContentProps) {
  return (
    <TabsPrimitive.Content
      data-slot="tabs-content"
      className={cn("flex flex-1 flex-col gap-6 p-6 outline-none", className)}
      {...props}
    />
  );
}

export default TabsContent;
