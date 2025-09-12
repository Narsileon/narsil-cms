import { cn } from "@narsil-cms/lib/utils";
import { cva } from "class-variance-authority";
import { Icon } from "@narsil-cms/components/icon";
import { NavigationMenu as NavigationMenuPrimitive } from "radix-ui";

const navigationMenuTriggerStyle = cva(
  cn(
    "group inline-flex h-9 w-max items-center justify-center rounded-md bg-background px-4 py-2 text-sm font-medium transition-[color,box-shadow] outline-none",
    "disabled:pointer-events-none disabled:opacity-50",
    "focus-visible:ring-2 focus-visible:ring-ring/50 focus-visible:outline-1",
    "focus:text-accent-foreground",
    "hover:bg-accent hover:text-accent-foreground focus:bg-accent",
    "data-[state=open]:focus:bg-accent",
    "data-[state=open]:hover:bg-accent",
    "data-[state=open]:bg-accent/50 data-[state=open]:text-accent-foreground",
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
      <Icon
        className={cn(
          "relative top-[1px] ml-1 size-3 transition duration-300",
          "group-data-[state=open]:rotate-180",
        )}
        aria-hidden="true"
        name="chevron-down"
      />
    </NavigationMenuPrimitive.Trigger>
  );
}

export default NavigationMenuTrigger;
