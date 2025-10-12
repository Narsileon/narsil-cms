import { cn } from "@narsil-cms/lib/utils";
import { Checkbox } from "radix-ui";
import { type ComponentProps } from "react";

type CheckboxRootProps = ComponentProps<typeof Checkbox.Root>;

function CheckboxRoot({ className, ...props }: CheckboxRootProps) {
  return (
    <Checkbox.Root
      data-slot="checkbox-root"
      className={cn(
        "size-4.5 border-input peer shrink-0 cursor-pointer rounded-[4px] border shadow-sm outline-none transition-shadow",
        "aria-invalid:border-destructive aria-invalid:ring-destructive/20",
        "dark:aria-invalid:ring-destructive/40",
        "data-[state=checked]:border-primary data-[state=checked]:bg-primary data-[state=checked]:text-primary-foreground",
        "data-[state=indeterminate]:text-primary",
        "disabled:cursor-not-allowed disabled:opacity-50",
        "focus-visible:border-shine",
        className,
      )}
      {...props}
    />
  );
}

export default CheckboxRoot;
