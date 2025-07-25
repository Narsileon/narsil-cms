import { cn } from "@narsil-cms/lib/utils";
import useSidebar from "./sidebar-context";

type SidebarRailProps = React.ComponentProps<"button"> & {};

function SidebarRail({ className, ...props }: SidebarRailProps) {
  const { toggleSidebar } = useSidebar();

  return (
    <button
      data-sidebar="rail"
      data-slot="sidebar-rail"
      aria-label="Toggle Sidebar"
      tabIndex={-1}
      onClick={toggleSidebar}
      title="Toggle Sidebar"
      className={cn(
        "absolute inset-y-0 z-20 hidden w-4 -translate-x-1/2 transition-all ease-linear sm:flex",
        "after:absolute after:inset-y-0 after:left-1/2 after:w-[2px]",
        "group-data-[collapsible=offcanvas]:after:left-full",
        "group-data-[collapsible=offcanvas]:translate-x-0",
        "group-data-[side=left]:-right-4",
        "group-data-[side=right]:left-0",
        "hover:after:bg-sidebar-border",
        "hover:group-data-[collapsible=offcanvas]:bg-sidebar",
        "in-data-[side=left]:cursor-w-resize",
        "in-data-[side=right]:cursor-e-resize",
        "[[data-side=left][data-collapsible=offcanvas]_&]:-right-2",
        "[[data-side=left][data-state=collapsed]_&]:cursor-e-resize",
        "[[data-side=right][data-collapsible=offcanvas]_&]:-left-2",
        "[[data-side=right][data-state=collapsed]_&]:cursor-w-resize",
        className,
      )}
      {...props}
    />
  );
}

export default SidebarRail;
