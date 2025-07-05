import { cn } from "@/lib/utils";

export type SidebarHeaderProps = React.ComponentProps<"div"> & {};

function SidebarHeader({ className, ...props }: SidebarHeaderProps) {
  return (
    <div
      data-slot="sidebar-header"
      data-sidebar="header"
      className={cn("grid items-center gap-3 px-3", className)}
      {...props}
    />
  );
}

export default SidebarHeader;
