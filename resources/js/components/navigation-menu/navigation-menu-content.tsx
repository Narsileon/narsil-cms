import { NavigationMenu } from "@base-ui/react/navigation-menu";
import { cn } from "@narsil-cms/lib/utils";

function NavigationMenuContent({ className, ...props }: NavigationMenu.Content.Props) {
  return (
    <NavigationMenu.Content
      data-slot="navigation-menu-content"
      className={cn(
        "h-full w-auto p-1 transition-[opacity,transform,translate] duration-300",
        "**:data-[slot=navigation-menu-link]:focus:outline-none",
        "**:data-[slot=navigation-menu-link]:focus:ring-0",
        "data-[motion^=from-]:animate-in",
        "data-[motion^=from-]:fade-in",
        "data-[motion^=to-]:animate-out",
        "data-[motion^=to-]:fade-out",
        "data-[motion=from-end]:slide-in-from-right-52",
        "data-[motion=from-start]:slide-in-from-left-52",
        "data-[motion=to-end]:slide-out-to-right-52",
        "data-[motion=to-start]:slide-out-to-left-52",
        "data-ending-style:data-[activation-direction=left]:translate-x-[50%]",
        "data-ending-style:data-[activation-direction=right]:translate-x-[-50%]",
        "data-ending-style:opacity-0",
        "data-starting-style:data-[activation-direction=left]:translate-x-[-50%]",
        "data-starting-style:data-[activation-direction=right]:translate-x-[50%]",
        "data-starting-style:opacity-0",
        "group-data-[viewport=false]/navigation-menu:bg-popover",
        "group-data-[viewport=false]/navigation-menu:data-closed:animate-out",
        "group-data-[viewport=false]/navigation-menu:data-closed:fade-out-0",
        "group-data-[viewport=false]/navigation-menu:data-closed:zoom-out-95",
        "group-data-[viewport=false]/navigation-menu:data-open:animate-in",
        "group-data-[viewport=false]/navigation-menu:data-open:fade-in-0",
        "group-data-[viewport=false]/navigation-menu:data-open:zoom-in-95",
        "group-data-[viewport=false]/navigation-menu:duration-300",
        "group-data-[viewport=false]/navigation-menu:ring-1",
        "group-data-[viewport=false]/navigation-menu:ring-foreground/10",
        "group-data-[viewport=false]/navigation-menu:rounded-lg",
        "group-data-[viewport=false]/navigation-menu:shadow",
        "group-data-[viewport=false]/navigation-menu:text-popover-foreground",
        className,
      )}
      {...props}
    />
  );
}

export default NavigationMenuContent;
