import { Tabs } from "@base-ui/react/tabs";
import { cn } from "@narsil-cms/lib/utils";

function TabsPanel({ className, ...props }: Tabs.Panel.Props) {
  return (
    <Tabs.Panel
      data-slot="tabs-panel"
      className={cn("flex flex-1 flex-col gap-4 p-4 text-sm outline-none", className)}
      {...props}
    />
  );
}

export default TabsPanel;
