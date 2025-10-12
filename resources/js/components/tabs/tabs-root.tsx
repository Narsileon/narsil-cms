import { useMinMd } from "@narsil-cms/hooks/use-breakpoints";
import { cn } from "@narsil-cms/lib/utils";
import { Tabs } from "radix-ui";
import { type ComponentProps } from "react";

type TabsRootProps = ComponentProps<typeof Tabs.Root>;

function TabsRoot({ className, orientation, ...props }: TabsRootProps) {
  const minMd = useMinMd();

  orientation = minMd ? orientation : "horizontal";

  return (
    <Tabs.Root
      data-slot="tabs"
      className={cn(
        "flex",
        "data-[orientation=vertical]:flex-row data-[orientation=horizontal]:flex-col",
        className,
      )}
      orientation={orientation}
      {...props}
    />
  );
}

export default TabsRoot;
