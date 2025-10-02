import { RadioGroup } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type RadioGroupItemProps = ComponentProps<typeof RadioGroup.Item> & {};

function RadioGroupItem({ className, ...props }: RadioGroupItemProps) {
  return (
    <RadioGroup.Item
      data-slot="radio-group-item"
      className={cn(
        "border-input text-primary shadow-xs aspect-square size-4 shrink-0 rounded-full border outline-none transition-[color,box-shadow]",
        "aria-invalid:border-destructive aria-invalid:ring-destructive/20",
        "dark:bg-input/30 dark:aria-invalid:ring-destructive/40",
        "disabled:cursor-not-allowed disabled:opacity-50",
        "focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-2",
        className,
      )}
      {...props}
    />
  );
}

export default RadioGroupItem;
