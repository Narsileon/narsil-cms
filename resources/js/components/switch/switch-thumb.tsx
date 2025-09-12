import { Switch as SwitchPrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type SwitchThumbProps = React.ComponentProps<typeof SwitchPrimitive.Thumb> & {};

function SwitchThumb({ className, ...props }: SwitchThumbProps) {
  return (
    <SwitchPrimitive.Thumb
      data-slot="switch-thumb"
      className={cn(
        "pointer-events-none block size-4 rounded-full bg-constructive-foreground ring-0 transition-transform will-change-transform",
        "data-[state=checked]:translate-x-[calc(100%-2px)] data-[state=unchecked]:translate-x-0",
        className,
      )}
      {...props}
    />
  );
}

export default SwitchThumb;
