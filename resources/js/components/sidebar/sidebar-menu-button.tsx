import { cva, type VariantProps } from "class-variance-authority";
import { Slot } from "radix-ui";
import { type ComponentProps } from "react";

import { Tooltip } from "@narsil-cms/blocks";
import { cn } from "@narsil-cms/lib/utils";

import useSidebar from "./sidebar-context";

const sidebarMenuButtonVariants = cva(
  cn(
    "peer/menu-button flex w-full cursor-pointer items-center gap-2 truncate overflow-hidden rounded-md p-2 text-left ring-sidebar-ring outline-hidden transition-[width,height,padding]",
    "active:bg-sidebar-accent active:text-sidebar-accent-foreground",
    "aria-disabled:pointer-events-none aria-disabled:opacity-50",
    "data-[active=true]:bg-sidebar-accent data-[active=true]:text-sidebar-accent-foreground",
    "data-[state=open]:hover:bg-sidebar-accent data-[state=open]:hover:text-sidebar-accent-foreground",
    "disabled:pointer-events-none disabled:opacity-50",
    "focus-visible:ring-2",
    "group-data-[collapsible=icon]:size-9! group-data-[collapsible=icon]:p-2!",
    "group-has-data-[sidebar=menu-action]/menu-item:pr-8",
    "hover:bg-sidebar-accent hover:text-sidebar-accent-foreground",
    "[&>span:last-child]:truncate [&>svg]:size-5 [&>svg]:shrink-0",
  ),
  {
    variants: {
      variant: {
        default: "hover:bg-sidebar-accent hover:text-sidebar-accent-foreground",
        outline: cn(
          "bg-background shadow-[0_0_0_1px_hsl(var(--sidebar-border))]",
          "hover:bg-sidebar-accent hover:text-sidebar-accent-foreground hover:shadow-[0_0_0_1px_hsl(var(--sidebar-accent))]",
        ),
      },
      size: {
        default: "h-9",
        sm: "h-7 text-xs",
        lg: "h-11 group-data-[collapsible=icon]:p-0!",
      },
    },
    defaultVariants: {
      variant: "default",
      size: "default",
    },
  },
);

type SidebarMenuButtonProps = ComponentProps<"button"> &
  VariantProps<typeof sidebarMenuButtonVariants> & {
    asChild?: boolean;
    isActive?: boolean;
    tooltip?: string | React.ReactNode;
  };

function SidebarMenuButton({
  asChild = false,
  isActive = false,
  variant = "default",
  size = "default",
  tooltip,
  className,
  ...props
}: SidebarMenuButtonProps) {
  const Comp = asChild ? Slot.Root : "button";

  const { isMobile, state } = useSidebar();

  const button = (
    <Comp
      data-slot="sidebar-menu-button"
      data-active={isActive}
      data-sidebar="menu-button"
      data-size={size}
      className={cn(
        sidebarMenuButtonVariants({
          className: className,
          size: size,
          variant: variant,
        }),
      )}
      {...props}
    />
  );

  if (!tooltip) {
    return button;
  }

  return (
    <Tooltip
      contentProps={{
        align: "center",
        hidden: state !== "collapsed" || isMobile,
        side: "right",
      }}
      tooltip={tooltip}
    >
      {button}
    </Tooltip>
  );
}

export default SidebarMenuButton;
