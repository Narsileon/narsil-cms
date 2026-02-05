import {
  DialogBackdrop,
  DialogDescription,
  DialogHeader,
  DialogPopup,
  DialogPortal,
  DialogRoot,
  DialogTitle,
} from "@narsil-ui/components/dialog";
import { cn } from "@narsil-ui/lib/utils";
import { type CSSProperties, type ComponentProps } from "react";
import useSidebar from "./sidebar-context";

type SidebarRootProps = ComponentProps<"div"> & {
  collapsible?: "offcanvas" | "icon" | "none";
  side?: "left" | "right";
  variant?: "sidebar" | "floating" | "inset";
};

function SidebarRoot({
  children,
  className,
  collapsible = "offcanvas",
  side = "left",
  variant = "sidebar",
  ...props
}: SidebarRootProps) {
  const { isMobile, mobileWidth, openMobile, state, setOpenMobile } = useSidebar();

  if (collapsible === "none") {
    return (
      <div
        data-slot="sidebar"
        className={cn(
          "flex h-full w-(--sidebar-width) flex-col bg-sidebar text-sidebar-foreground",
          className,
        )}
        {...props}
      >
        {children}
      </div>
    );
  }

  if (isMobile) {
    return (
      <DialogRoot open={openMobile} onOpenChange={setOpenMobile} {...props}>
        <DialogPortal>
          <DialogBackdrop />
          <DialogPopup
            data-slot="sidebar"
            data-mobile="true"
            data-sidebar="sidebar"
            className={cn(
              "w-(--sidebar-width) bg-sidebar p-0 text-sidebar-foreground",
              "[&>button]:hidden",
            )}
            style={
              {
                "--sidebar-width": mobileWidth,
              } as CSSProperties
            }
            variant="left"
          >
            <DialogHeader className="sr-only">
              <DialogTitle>Sidebar</DialogTitle>
              <DialogDescription>Displays the mobile sidebar.</DialogDescription>
            </DialogHeader>
            <div className="flex h-full w-full flex-col">{children}</div>
          </DialogPopup>
        </DialogPortal>
      </DialogRoot>
    );
  }

  return (
    <div
      data-slot="sidebar-root"
      data-collapsible={state === "collapsed" ? collapsible : ""}
      data-side={side}
      data-state={state}
      data-variant={variant}
      className="group peer hidden text-sidebar-foreground md:block"
    >
      <div
        data-slot="sidebar-gap"
        className={cn(
          "relative w-(--sidebar-width) bg-transparent transition-[width] duration-300 ease-linear",
          "group-data-[collapsible=offcanvas]:w-0",
          "group-data-[side=right]:rotate-180",
          variant === "floating" || variant === "inset"
            ? "group-data-[collapsible=icon]:w-[calc(var(--sidebar-width-icon)+(--spacing(4)))]"
            : "group-data-[collapsible=icon]:w-(--sidebar-width-icon)",
        )}
      />
      <div
        data-slot="sidebar-container"
        className={cn(
          "fixed inset-y-0 z-10 hidden h-svh w-(--sidebar-width) transition-[left,right,width] duration-300 ease-linear md:flex",
          side === "left"
            ? "left-0 group-data-[collapsible=offcanvas]:left-[calc(var(--sidebar-width)*-1)]"
            : "right-0 group-data-[collapsible=offcanvas]:right-[calc(var(--sidebar-width)*-1)]",
          variant === "floating" || variant === "inset"
            ? "p-2 group-data-[collapsible=icon]:w-[calc(var(--sidebar-width-icon)+(--spacing(4))+2px)]"
            : "group-data-[collapsible=icon]:w-(--sidebar-width-icon) group-data-[side=left]:border-r group-data-[side=right]:border-l",
          className,
        )}
        {...props}
      >
        <div
          data-sidebar="sidebar"
          data-slot="sidebar-inner"
          className={cn(
            "flex h-full w-full flex-col bg-sidebar",
            "group-data-[variant=floating]:rounded-md group-data-[variant=floating]:border group-data-[variant=floating]:border-sidebar-border group-data-[variant=floating]:shadow-sm",
          )}
        >
          {children}
        </div>
      </div>
    </div>
  );
}

export default SidebarRoot;
