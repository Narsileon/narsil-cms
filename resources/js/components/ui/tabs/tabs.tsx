import { cn } from "@/components/utils";
import { Root } from "@radix-ui/react-tabs";

export type TabsProps = React.ComponentProps<typeof Root> & {};

function Tabs({ className, ...props }: TabsProps) {
  return (
    <Root
      data-slot="tabs"
      className={cn("flex flex-col gap-2", className)}
      {...props}
    />
  );
}

export default Tabs;
