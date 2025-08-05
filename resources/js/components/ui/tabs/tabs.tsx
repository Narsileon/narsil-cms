import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Tabs as TabsPrimitive } from "radix-ui";
import { useMinMd } from "@narsil-cms/hooks/use-breakpoints";

type TabsProps = React.ComponentProps<typeof TabsPrimitive.Root> & {};

function Tabs({ className, orientation, ...props }: TabsProps) {
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

export default Tabs;
