import { Checkbox } from "@base-ui/react/checkbox";
import { cn } from "@narsil-cms/lib/utils";

function CheckboxRoot({ className, ...props }: Checkbox.Root.Props) {
  return (
    <Checkbox.Root
      data-slot="checkbox-root"
      className={cn(
        "peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-[4px] border border-input transition-colors outline-none",
        "after:absolute after:-inset-x-3 after:-inset-y-2",
        "aria-invalid:aria-checked:border-primary",
        "aria-invalid:border-destructive aria-invalid:ring-[3px] aria-invalid:ring-destructive/20",
        "dark:aria-invalid:border-destructive/50 dark:aria-invalid:ring-destructive/40",
        "dark:bg-input/30",
        "dark:data-checked:bg-primary",
        "data-checked:border-primary data-checked:bg-primary data-checked:text-primary-foreground",
        "disabled:cursor-not-allowed disabled:opacity-50",
        "focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50",
        "group-has-disabled/field:opacity-50",
        className,
      )}
      {...props}
    />
  );
}

export default CheckboxRoot;
