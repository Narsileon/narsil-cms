import { Slider } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type SliderThumbProps = ComponentProps<typeof Slider.Thumb>;

function SliderThumb({ className, ...props }: SliderThumbProps) {
  return (
    <Slider.Thumb
      data-slot="slider-thumb"
      className={cn(
        "border-primary bg-background ring-ring/50 block size-4 shrink-0 rounded-full border shadow-sm transition-[color,box-shadow]",
        "disabled:pointer-events-none disabled:opacity-50",
        "focus-visible:outline-hidden focus-visible:ring-2",
        "hover:ring-2",
        className,
      )}
      {...props}
    />
  );
}

export default SliderThumb;
