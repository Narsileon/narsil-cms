import { Switch } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type SwitchRootProps = ComponentProps<typeof Switch.Root> & {};

function SwitchRoot({ className, ...props }: SwitchRootProps) {
  return (
    <Switch.Root
      data-slot="switch-root"
      className={cn(
        "peer inline-flex h-[1.15rem] w-8 shrink-0 cursor-pointer items-center rounded-full border border-transparent shadow-xs transition-all outline-none",
        "data-[state=checked]:bg-constructive data-[state=unchecked]:bg-input",
        "disabled:cursor-not-allowed disabled:opacity-50",
        "focus-visible:border-ring focus-visible:ring-2 focus-visible:ring-ring/50",
        className,
      )}
      {...props}
    />
  );
}

export default SwitchRoot;
