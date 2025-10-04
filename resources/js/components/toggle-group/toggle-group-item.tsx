import { type VariantProps } from "class-variance-authority";
import { ToggleGroup } from "radix-ui";
import { type ComponentProps } from "react";

import { toggleRootVariants } from "@narsil-cms/components/toggle";
import { cn } from "@narsil-cms/lib/utils";

import useToggleGroup from "./toggle-group-context";

type ToggleGroupItemProps = ComponentProps<typeof ToggleGroup.Item> &
  VariantProps<typeof toggleRootVariants>;

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
        toggleRootVariants({
          size: context.size || size,
          variant: context.variant || variant,
        }),
        "min-w-0 flex-1 shrink-0 cursor-pointer rounded-none shadow-none",
        "first:rounded-l-md",
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
