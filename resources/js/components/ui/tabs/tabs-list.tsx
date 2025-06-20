import { cn } from "@/components";
import { List } from "@radix-ui/react-tabs";

export type TabsListProps = React.ComponentProps<typeof List> & {};

function TabsList({ className, ...props }: TabsListProps) {
  return (
    <List
      data-slot="tabs-list"
      className={cn(
        "bg-muted text-muted-foreground inline-flex h-9 w-fit items-center justify-center rounded-lg p-[3px]",
        className,
      )}
      {...props}
    />
  );
}
export default TabsList;
