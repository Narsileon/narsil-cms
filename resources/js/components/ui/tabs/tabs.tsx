import { cn } from "@/lib/utils";
import { Tabs as TabsPrimitive } from "radix-ui";

export type TabsProps = React.ComponentProps<typeof TabsPrimitive.Root> & {};

function Tabs({ className, ...props }: TabsProps) {
  return (
    <TabsPrimitive.Root
      data-slot="tabs"
      className={cn(
        "flex",
        "data-[orientation=horizontal]:flex-col data-[orientation=vertical]:flex-row",
        "data-[orientation=horizontal]:gap-2",
        className,
      )}
      {...props}
    />
  );
}

export default Tabs;
