import { Tabs } from "@base-ui/react/tabs";
import { useMinMd } from "@narsil-cms/hooks/use-breakpoints";
import { cn } from "@narsil-cms/lib/utils";

function TabsRoot({ className, orientation, ...props }: Tabs.Root.Props) {
  const minMd = useMinMd();

  orientation = minMd ? orientation : "horizontal";

  return (
    <Tabs.Root
      data-slot="tabs-root"
      className={cn(
        "group/tabs",
        "flex gap-2",
        "data-[orientation=horizontal]:flex-col",
        className,
      )}
      orientation={orientation}
      {...props}
    />
  );
}

export default TabsRoot;
