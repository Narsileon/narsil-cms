import { Switch } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type SwitchRootProps = ComponentProps<typeof Switch.Root> & {};

function SwitchRoot({ className, ...props }: SwitchRootProps) {
  return (
    <Switch.Root
      data-slot="switch-root"
      className={cn(
        "h-4.5 w-8.5 peer relative inline-flex shrink-0 cursor-pointer items-center rounded-full border shadow-sm outline-none",
        "focus-visible:border-shine transition-all",
        "data-[state=checked]:bg-constructive data-[state=unchecked]:bg-input",
        "disabled:cursor-not-allowed disabled:opacity-50",
        className,
      )}
      {...props}
    />
  );
}

export default SwitchRoot;
