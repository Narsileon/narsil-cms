import { ChevronDownIcon } from "lucide-react";
import { cn } from "@/lib/utils";
import { cva } from "class-variance-authority";
import { NavigationMenu as NavigationMenuPrimitive } from "radix-ui";

const navigationMenuTriggerStyle = cva(
  cn(
    "group inline-flex h-9 w-max items-center justify-center rounded-md bg-background px-4 py-2 text-sm font-medium outline-none transition-[color,box-shadow]",
    "disabled:pointer-events-none disabled:opacity-50",
    "focus-visible:ring-[3px] focus-visible:outline-1 focus-visible:ring-ring/50",
    "focus:text-accent-foreground",
    "hover:bg-accent hover:text-accent-foreground focus:bg-accent",
    "data-[state=open]:focus:bg-accent",
    "data-[state=open]:hover:bg-accent",
    "data-[state=open]:text-accent-foreground data-[state=open]:bg-accent/50",
  ),
);

type NavigationMenuTriggerProps = React.ComponentProps<
  typeof NavigationMenuPrimitive.Trigger
> & {};

function NavigationMenuTrigger({
  className,
  children,
  ...props
}: NavigationMenuTriggerProps) {
  return (
    <NavigationMenuPrimitive.Trigger
      data-slot="navigation-menu-trigger"
      className={cn(navigationMenuTriggerStyle(), "group", className)}
      {...props}
    >
      {children}
      <ChevronDownIcon
        className={cn(
          "relative top-[1px] ml-1 size-3 transition duration-300",
          "group-data-[state=open]:rotate-180",
        )}
        aria-hidden="true"
      />
    </NavigationMenuPrimitive.Trigger>
  );
}

export default NavigationMenuTrigger;
