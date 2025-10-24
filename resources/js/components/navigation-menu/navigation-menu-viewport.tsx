import { cn } from "@narsil-cms/lib/utils";
import { NavigationMenu } from "radix-ui";
import { type ComponentProps } from "react";

type NavigationMenuViewportProps = ComponentProps<typeof NavigationMenu.Viewport>;

function NavigationMenuViewport({ className, ...props }: NavigationMenuViewportProps) {
  return (
    <div className={cn("absolute top-full left-0 isolate z-50 flex justify-center")}>
      <NavigationMenu.Viewport
        data-slot="navigation-menu-viewport"
        className={cn(
          "origin-top-center relative mt-1.5 w-full overflow-hidden rounded-md border bg-popover text-popover-foreground shadow",
          "h-[--radix-navigation-menu-viewport-height] md:w-[--radix-navigation-menu-viewport-width]",
          "data-[state=open]:animate-in data-[state=open]:zoom-in-90",
          "data-[state=closed]:animate-out data-[state=closed]:zoom-out-95",
          className,
        )}
        {...props}
      />
    </div>
  );
}

export default NavigationMenuViewport;
