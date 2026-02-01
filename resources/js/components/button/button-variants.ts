import { cn } from "@narsil-cms/lib/utils";
import { cva } from "class-variance-authority";

const buttonVariants = cva(
  cn(
    "group/button",
    "inline-flex shrink-0 cursor-pointer items-center justify-center gap-2 rounded-md border border-transparent bg-clip-padding font-medium whitespace-nowrap transition-all duration-300 outline-none select-none",
    "aria-disabled:pointer-events-none aria-disabled:opacity-50",
    "aria-invalid:border-destructive aria-invalid:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:border-destructive/50 dark:aria-invalid:ring-destructive/40",
    "disabled:pointer-events-none disabled:opacity-50",
    "focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50",
    "[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4",
  ),
  {
    variants: {
      variant: {
        destructive: cn(
          "bg-destructive/80 text-destructive-foreground",
          "focus-visible:bg-destructive",
          "hover:bg-destructive",
        ),
        link: cn("text-primary underline-offset-4", "hover:underline"),
        ghost: cn(
          "focus-visible:bg-accent focus-visible:text-accent-foreground",
          "hover:bg-accent hover:text-accent-foreground",
        ),
        outline: cn(
          "border border-input bg-background shadow-sm",
          "focus-visible:border-shine",
          "hover:bg-accent hover:text-accent-foreground",
        ),
        primary: cn(
          "bg-primary/80 text-primary-foreground",
          "focus-visible:bg-primary",
          "hover:bg-primary",
          "[&_svg]:text-primary-foreground",
        ),
        secondary: cn(
          "bg-secondary/80 text-secondary-foreground",
          "focus-visible:bg-secondary",
          "hover:bg-secondary",
          "[&_svg]:text-secondary-foreground",
        ),
        sidebar: cn(
          "peer/menu-button w-full justify-start truncate rounded-md p-2 text-left ring-sidebar-ring outline-hidden transition-[width,height,padding]",
          "active:bg-sidebar-accent active:text-sidebar-accent-foreground",
          "data-[active=true]:bg-sidebar-accent data-[active=true]:text-sidebar-accent-foreground",
          "data-[state=open]:hover:bg-sidebar-accent data-[state=open]:hover:text-sidebar-accent-foreground",
          "focus-visible:bg-sidebar-accent focus-visible:text-sidebar-accent-foreground",
          "group-data-[collapsible=icon]:size-9! group-data-[collapsible=icon]:p-2!",
          "group-has-data-[sidebar=menu-action]/menu-item:pr-8",
          "hover:bg-sidebar-accent hover:text-sidebar-accent-foreground",
          "[&>span:last-child]:truncate [&>svg]:size-5",
        ),
        "ghost-secondary": cn(
          "focus-visible:bg-secondary focus-visible:text-secondary-foreground",
          "hover:bg-secondary hover:text-secondary-foreground",
        ),
      },
      size: {
        default: "h-9 px-3 py-2 has-[>svg]:px-2",
        sm: "h-8 gap-1.5 px-3 has-[>svg]:px-2",
        lg: "h-10 px-6 has-[>svg]:px-2",
        icon: "size-9",
        link: "",
        "icon-sm": "size-7",
      },
    },
    defaultVariants: {
      variant: "primary",
      size: "default",
    },
  },
);

export default buttonVariants;
