import { cn } from "@/components/utils";
import { Tabs as TabsPrimitive } from "radix-ui";

export type TabsProps = React.ComponentProps<typeof TabsPrimitive.Root> & {};

function Tabs({ className, ...props }: TabsProps) {
  return (
    <TabsPrimitive.Root
      data-slot="tabs"
      className={cn("flex flex-col gap-2", className)}
      {...props}
    />
  );
}

export default Tabs;
