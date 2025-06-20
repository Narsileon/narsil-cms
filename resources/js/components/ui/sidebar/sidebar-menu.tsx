import { cn } from "@/components/utils";

export type SidebarMenuProps = React.ComponentProps<"ul"> & {};

function SidebarMenu({ className, ...props }: SidebarMenuProps) {
  return (
    <ul
      data-slot="sidebar-menu"
      data-sidebar="menu"
      className={cn("flex w-full min-w-0 flex-col gap-1", className)}
      {...props}
    />
  );
}

export default SidebarMenu;
