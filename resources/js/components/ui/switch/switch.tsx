import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Switch as SwitchPrimitive } from "radix-ui";

type SwitchProps = React.ComponentProps<typeof SwitchPrimitive.Root> & {};

function Switch({ className, ...props }: SwitchProps) {
  return (
    <SwitchPrimitive.Root
      data-slot="switch"
      className={cn(
        "peer inline-flex h-[1.15rem] w-8 shrink-0 cursor-pointer items-center rounded-full border border-transparent shadow-xs transition-all outline-none",
        "data-[state=checked]:bg-constructive data-[state=unchecked]:bg-input",
        "disabled:cursor-not-allowed disabled:opacity-50",
        "focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-2",
        className,
      )}
      {...props}
    >
      <SwitchPrimitive.Thumb
        data-slot="switch-thumb"
        className={cn(
          "bg-constructive-foreground pointer-events-none block size-4 rounded-full ring-0 transition-transform will-change-transform",
          "data-[state=checked]:translate-x-[calc(100%-2px)] data-[state=unchecked]:translate-x-0",
        )}
      />
    </SwitchPrimitive.Root>
  );
}

export default Switch;
