import { cn } from "@narsil-cms/lib/utils";
import { type VariantProps } from "class-variance-authority";
import { Select } from "radix-ui";
import { type ComponentProps } from "react";
import selectTriggerVariants from "./select-trigger-variants";

type SelectTriggerProps = ComponentProps<typeof Select.Trigger> &
  VariantProps<typeof selectTriggerVariants>;

function SelectTrigger({ className, size = "default", variant, ...props }: SelectTriggerProps) {
  return (
    <Select.Trigger
      data-slot="select-trigger"
      data-size={size}
      className={cn(
        selectTriggerVariants({
          className: className,
          size: size,
          variant: variant,
        }),
      )}
      {...props}
    />
  );
}

export default SelectTrigger;
