import { cn } from "@/components";
import { Item } from "@radix-ui/react-toggle-group";
import { toggleVariants } from "./toggle";
import { useToggleGroupContext } from "./toggle-group";
import { VariantProps } from "class-variance-authority";

export type ToggleGroupItemProps = React.ComponentProps<typeof Item> &
  VariantProps<typeof toggleVariants> & {};

function ToggleGroupItem({
  children,
  className,
  size,
  variant,
  ...props
}: ToggleGroupItemProps) {
  const context = useToggleGroupContext();

  return (
    <Item
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
    </Item>
  );
}

export default ToggleGroupItem;
