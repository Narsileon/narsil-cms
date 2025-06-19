import { cn } from "@/Components";
import { SubTrigger } from "@radix-ui/react-menubar";
import { ChevronRightIcon } from "lucide-react";

export type MenubarSubTriggerProps = React.ComponentProps<typeof SubTrigger> & {
  inset?: boolean;
};

function MenubarSubTrigger({
  children,
  className,
  inset,
  ...props
}: MenubarSubTriggerProps) {
  return (
    <SubTrigger
      data-slot="menubar-sub-trigger"
      data-inset={inset}
      className={cn(
        "flex cursor-default items-center rounded-sm px-2 py-1.5 text-sm outline-none select-none",
        "focus:bg-accent focus:text-accent-foreground",
        "data-[state=open]:bg-accent data-[state=open]:text-accent-foreground",
        "data-[inset]:pl-8",
        className,
      )}
      {...props}
    >
      {children}
      <ChevronRightIcon className="ml-auto size-4" />
    </SubTrigger>
  );
}

export default MenubarSubTrigger;
