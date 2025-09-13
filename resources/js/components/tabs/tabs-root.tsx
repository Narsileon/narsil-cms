import { Tabs as TabsPrimitive } from "radix-ui";

import { useMinMd } from "@narsil-cms/hooks/use-breakpoints";
import { cn } from "@narsil-cms/lib/utils";

type TabsRootProps = React.ComponentProps<typeof TabsPrimitive.Root> & {};

function TabsRoot({ className, orientation, ...props }: TabsRootProps) {
  const minMd = useMinMd();

  orientation = minMd ? orientation : "horizontal";

  return (
    <TabsPrimitive.Root
      data-slot="tabs"
      className={cn(
        "flex",
        "data-[orientation=horizontal]:flex-col data-[orientation=vertical]:flex-row",
        className,
      )}
      orientation={orientation}
      {...props}
    />
  );
}

export default TabsRoot;
