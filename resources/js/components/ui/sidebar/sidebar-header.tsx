import { cn } from "@/components/utils";

export type SidebarHeaderProps = React.ComponentProps<"div"> & {};

function SidebarHeader({ className, ...props }: SidebarHeaderProps) {
  return (
    <div
      data-slot="sidebar-header"
      data-sidebar="header"
      className={cn("flex flex-col gap-2 p-2", className)}
      {...props}
    />
  );
}

export default SidebarHeader;
