import { cn } from "@narsil-cms/lib/utils";
import { Slot as SlotPrimitive } from "radix-ui";

type SidebarGroupActionProps = React.ComponentProps<"button"> & {
  asChild?: boolean;
};

function SidebarGroupAction({
  asChild = false,
  className,
  ...props
}: SidebarGroupActionProps) {
  const Comp = asChild ? SlotPrimitive.Slot : "button";

  return (
    <Comp
      data-slot="sidebar-group-action"
      data-sidebar="group-action"
      className={cn(
        "text-sidebar-foreground ring-sidebar-ring absolute top-3.5 right-3 flex aspect-square w-5 items-center justify-center rounded-md p-0 outline-hidden transition-transform",
        "after:absolute after:-inset-2 md:after:hidden",
        "focus-visible:ring-2",
        "hover:bg-sidebar-accent hover:text-sidebar-accent-foreground",
        "[&>svg]:size-4 [&>svg]:shrink-0",
        "group-data-[collapsible=icon]:hidden",
        className,
      )}
      {...props}
    />
  );
}

export default SidebarGroupAction;
