import { cn } from "@/Components";
import { cva, VariantProps } from "class-variance-authority";
import { Root } from "@radix-ui/react-toggle";

export const toggleVariants = cva(
  cn(
    "inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium whitespace-nowrap outline-none transition-[color,box-shadow]",
    "aria-invalid:ring-destructive/20 aria-invalid:border-destructive",
    "dark:aria-invalid:ring-destructive/40",
    "disabled:pointer-events-none disabled:opacity-50",
    "focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]",
    "hover:bg-muted hover:text-muted-foreground",
    "data-[state=on]:bg-accent data-[state=on]:text-accent-foreground",
    "[&_svg]:pointer-events-none [&_svg:not([class*='size-'])]:size-4 [&_svg]:shrink-0",
  ),
  {
    variants: {
      variant: {
        default: "bg-transparent",
        outline: cn(
          "border border-input bg-transparent shadow-xs",
          "hover:bg-accent hover:text-accent-foreground",
        ),
      },
      size: {
        default: "h-9 px-2 min-w-9",
        sm: "h-8 px-1.5 min-w-8",
        lg: "h-10 px-2.5 min-w-10",
      },
    },
    defaultVariants: {
      variant: "default",
      size: "default",
    },
  },
);

export type ToggleProps = React.ComponentProps<typeof Root> &
  VariantProps<typeof toggleVariants> & {};

function Toggle({ className, variant, size, ...props }: ToggleProps) {
  return (
    <Root
      className={cn(
        toggleVariants({
          className: className,
          size: size,
          variant: variant,
        }),
      )}
      data-slot="toggle"
      {...props}
    />
  );
}

export default Toggle;
