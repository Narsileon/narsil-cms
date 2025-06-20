import { cn } from "@/components/utils";

export type SidebarGroupProps = React.ComponentProps<"div"> & {};

function SidebarGroup({ className, ...props }: SidebarGroupProps) {
  return (
    <div
      data-slot="sidebar-group"
      data-sidebar="group"
      className={cn("relative flex w-full min-w-0 flex-col p-2", className)}
      {...props}
    />
  );
}

export default SidebarGroup;
