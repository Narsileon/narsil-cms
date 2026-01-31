import { Select } from "@base-ui/react/select";
import { cn } from "@narsil-cms/lib/utils";
import { VariantProps } from "class-variance-authority";
import selectTriggerVariants from "./select-trigger-variants";

type SelectTriggerProps = Select.Trigger.Props &
  VariantProps<typeof selectTriggerVariants> & {
    size?: "sm" | "default";
  };

function SelectTrigger({ className, size = "default", variant, ...props }: SelectTriggerProps) {
  return (
    <Select.Trigger
      data-slot="select-trigger"
      data-size={size}
      className={cn(
        selectTriggerVariants({
          className: className,
          variant: variant,
        }),
      )}
      {...props}
    />
  );
}

export default SelectTrigger;
