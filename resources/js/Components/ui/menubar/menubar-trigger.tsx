import { cn } from "@/Components/utils";
import { Trigger } from "@radix-ui/react-menubar";

export type MenubarTriggerProps = React.ComponentProps<typeof Trigger> & {};

function MenubarTrigger({ className, ...props }: MenubarTriggerProps) {
  return (
    <Trigger
      data-slot="menubar-trigger"
      className={cn(
        "flex items-center rounded-sm px-2 py-1 text-sm font-medium outline-hidden select-none",
        "focus:bg-accent focus:text-accent-foreground",
        "data-[state=open]:bg-accent data-[state=open]:text-accent-foreground",
        className,
      )}
      {...props}
    />
  );
}

export default MenubarTrigger;
