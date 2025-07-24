import { cn } from "@narsil-cms/lib/utils";

type SidebarHeaderProps = React.ComponentProps<"div"> & {};

function SidebarHeader({ className, ...props }: SidebarHeaderProps) {
  return (
    <div
      data-slot="sidebar-header"
      data-sidebar="header"
      className={cn("grid items-center gap-2 px-2", className)}
      {...props}
    />
  );
}

export default SidebarHeader;
