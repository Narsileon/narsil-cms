import { type VariantProps } from "class-variance-authority";
import { ToggleGroup } from "radix-ui";

import { toggleVariants } from "@narsil-cms/components/toggle";
import { cn } from "@narsil-cms/lib/utils";

import useToggleGroup from "./toggle-group-context";

type ToggleGroupItemProps = React.ComponentProps<typeof ToggleGroup.Item> &
  VariantProps<typeof toggleVariants> & {};

function ToggleGroupItem({
  className,
  size,
  variant,
  ...props
}: ToggleGroupItemProps) {
  const context = useToggleGroup();

  return (
    <ToggleGroup.Item
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
    />
  );
}

export default ToggleGroupItem;
