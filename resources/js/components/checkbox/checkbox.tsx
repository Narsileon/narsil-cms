import { Checkbox as CheckboxPrimitive } from "radix-ui";

import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";

type CheckboxProps = React.ComponentProps<typeof CheckboxPrimitive.Root> & {};

function Checkbox({ className, ...props }: CheckboxProps) {
  return (
    <CheckboxPrimitive.Root
      data-slot="checkbox"
      className={cn(
        "peer size-4.5 shrink-0 cursor-pointer rounded-[4px] border border-input shadow-xs transition-shadow outline-none",
        "aria-invalid:border-destructive aria-invalid:ring-destructive/20",
        "dark:aria-invalid:ring-destructive/40",
        "data-[state=checked]:bg-primary dark:bg-input/30",
        "data-[state=checked]:border-primary data-[state=checked]:text-primary-foreground dark:data-[state=checked]:bg-primary",
        "disabled:cursor-not-allowed disabled:opacity-50",
        "focus-visible:border-ring focus-visible:ring-2 focus-visible:ring-ring/50",
        className,
      )}
      {...props}
    >
      <CheckboxPrimitive.Indicator
        data-slot="checkbox-indicator"
        className="flex items-center justify-center text-current transition-none"
      >
        <Icon className="size-3.5" name="check" />
      </CheckboxPrimitive.Indicator>
    </CheckboxPrimitive.Root>
  );
}

export default Checkbox;
