import { Switch } from "@base-ui/react/switch";
import { cn } from "@narsil-cms/lib/utils";

type SwitchRootProps = Switch.Root.Props & {
  size?: "sm" | "default";
};

function SwitchRoot({ className, size = "default", ...props }: SwitchRootProps) {
  return (
    <Switch.Root
      data-slot="switch-root"
      data-size={size}
      className={cn(
        "peer group/switch relative inline-flex shrink-0 cursor-pointer items-center rounded-full border border-transparent transition-all outline-none",
        "aria-invalid:border-destructive aria-invalid:ring-[3px] aria-invalid:ring-destructive/20",
        "dark:aria-invalid:border-destructive/50 dark:aria-invalid:ring-destructive/40",
        "dark:data-unchecked:bg-input",
        "data-[size=default]:h-4.5 data-[size=default]:w-8.5",
        "data-[size=sm]:h-3.5 data-[size=sm]:w-6.5",
        "data-checked:bg-constructive",
        "data-disabled:cursor-not-allowed data-disabled:opacity-50",
        "data-unchecked:bg-input",
        "focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50",
        className,
      )}
      {...props}
    />
  );
}

export default SwitchRoot;
