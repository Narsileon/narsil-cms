import { Tabs } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type TabsContentProps = React.ComponentProps<typeof Tabs.Content> & {};

function TabsContent({ className, ...props }: TabsContentProps) {
  return (
    <Tabs.Content
      data-slot="tabs-content"
      className={cn("flex flex-1 flex-col gap-4 p-4 outline-none", className)}
      {...props}
    />
  );
}

export default TabsContent;
