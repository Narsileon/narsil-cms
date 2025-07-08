import { cn } from "@/lib/utils";
import { ToggleGroup as ToggleGroupPrimitive } from "radix-ui";
import { toggleVariants } from "./toggle";
import useToggleGroup from "./toggle-group-context";
import type { VariantProps } from "class-variance-authority";

type ToggleGroupItemProps = React.ComponentProps<
  typeof ToggleGroupPrimitive.Item
> &
  VariantProps<typeof toggleVariants> & {};

function ToggleGroupItem({
  children,
  className,
  size,
  variant,
  ...props
}: ToggleGroupItemProps) {
  const context = useToggleGroup();

  return (
    <ToggleGroupPrimitive.Item
      data-slot="toggle-group-item"
      data-size={context.size || size}
      data-variant={context.variant || variant}
      className={cn(
        toggleVariants({
          size: context.size || size,
          variant: context.variant || variant,
        }),
        "min-w-0 flex-1 shrink-0 rounded-none shadow-none",
        "first:rounded-l-md",
        "focus:z-10",
        "focus-visible:z-10",
        "last:rounded-r-md",
        "data-[variant=outline]:border-l-0",
        "data-[variant=outline]:first:border-l",
        className,
      )}
      {...props}
    >
      {children}
    </ToggleGroupPrimitive.Item>
  );
}

export default ToggleGroupItem;
