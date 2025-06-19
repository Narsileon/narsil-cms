import { cn } from "@/Components";
import { Content } from "@radix-ui/react-tabs";

export type TabsContentProps = React.ComponentProps<typeof Content> & {};

function TabsContent({ className, ...props }: TabsContentProps) {
  return (
    <Content
      data-slot="tabs-content"
      className={cn("flex-1 outline-none", className)}
      {...props}
    />
  );
}

export default TabsContent;
