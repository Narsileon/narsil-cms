import { cn } from "@narsil-cms/lib/utils";
import { Slot as SlotPrimitive } from "radix-ui";

type SidebarGroupLabelProps = React.ComponentProps<"div"> & {
  asChild?: boolean;
};

function SidebarGroupLabel({
  className,
  asChild = false,
  ...props
}: SidebarGroupLabelProps) {
  const Comp = asChild ? SlotPrimitive.Slot : "div";

  return (
    <Comp
      data-slot="sidebar-group-label"
      data-sidebar="group-label"
      className={cn(
        "text-sidebar-foreground/70 ring-sidebar-ring flex h-8 shrink-0 items-center rounded-md px-2 text-xs font-medium outline-hidden transition-[margin,opacity] duration-200 ease-linear",
        "focus-visible:ring-2",
        "[&>svg]:size-4 [&>svg]:shrink-0",
        "group-data-[collapsible=icon]:-z-10 group-data-[collapsible=icon]:-mt-8 group-data-[collapsible=icon]:opacity-0",
        className,
      )}
      {...props}
    />
  );
}

export default SidebarGroupLabel;
