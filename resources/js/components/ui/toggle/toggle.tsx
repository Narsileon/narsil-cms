import { cn } from "@narsil-cms/lib/utils";
import { cva } from "class-variance-authority";
import { Toggle as TogglePrimitive } from "radix-ui";
import type { VariantProps } from "class-variance-authority";

export const toggleVariants = cva(
  cn(
    "inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium whitespace-nowrap outline-none transition-[color,box-shadow]",
    "aria-invalid:ring-destructive/20 aria-invalid:border-destructive",
    "dark:aria-invalid:ring-destructive/40",
    "dark:hover:bg-accent/50",
    "dark:data-[state=on]:bg-accent/50",
    "disabled:pointer-events-none disabled:opacity-50",
    "focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]",
    "hover:bg-accent hover:text-accent-foreground",
    "data-[state=on]:bg-accent data-[state=on]:text-accent-foreground",
    "[&_svg]:pointer-events-none [&_svg:not([class*='size-'])]:size-4 [&_svg]:shrink-0",
  ),
  {
    variants: {
      variant: {
        default: "bg-transparent",
        outline: cn("border border-input bg-transparent shadow-xs"),
      },
      size: {
        default: "h-9 px-4 min-w-9",
        sm: "h-8 px-1.5 min-w-8",
        lg: "h-10 px-2.5 min-w-10",
        icon: "size-9",
      },
    },
    defaultVariants: {
      variant: "default",
      size: "default",
    },
  },
);

type ToggleProps = React.ComponentProps<typeof TogglePrimitive.Root> &
  VariantProps<typeof toggleVariants> & {};

function Toggle({ className, variant, size, ...props }: ToggleProps) {
  return (
    <TogglePrimitive.Root
      data-slot="toggle"
      className={cn(
        toggleVariants({
          className: className,
          size: size,
          variant: variant,
        }),
      )}
      {...props}
    />
  );
}

export default Toggle;
