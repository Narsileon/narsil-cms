import { Switch } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type SwitchThumbProps = ComponentProps<typeof Switch.Thumb>;

function SwitchThumb({ className, ...props }: SwitchThumbProps) {
  return (
    <Switch.Thumb
      data-slot="switch-thumb"
      className={cn(
        "bg-constructive-foreground pointer-events-none block size-4 rounded-full ring-0 transition-transform will-change-transform",
        "data-[state=checked]:translate-x-[calc(100%)] data-[state=unchecked]:translate-x-0",
        className,
      )}
      {...props}
    />
  );
}

export default SwitchThumb;
