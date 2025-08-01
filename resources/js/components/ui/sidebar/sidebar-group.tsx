import { cn } from "@narsil-cms/lib/utils";

type SidebarGroupProps = React.ComponentProps<"div"> & {};

function SidebarGroup({ className, ...props }: SidebarGroupProps) {
  return (
    <div
      data-slot="sidebar-group"
      data-sidebar="group"
      className={cn("relative flex w-full min-w-0 flex-col", className)}
      {...props}
    />
  );
}

export default SidebarGroup;
