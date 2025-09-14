import { Slider } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type SliderThumbProps = React.ComponentProps<typeof Slider.Thumb> & {};

function SliderThumb({ className, ...props }: SliderThumbProps) {
  return (
    <Slider.Thumb
      data-slot="slider-thumb"
      className={cn(
        "block size-4 shrink-0 rounded-full border border-primary bg-background shadow-sm ring-ring/50 transition-[color,box-shadow]",
        "disabled:pointer-events-none disabled:opacity-50",
        "focus-visible:ring-2 focus-visible:outline-hidden",
        "hover:ring-2",
        className,
      )}
      {...props}
    />
  );
}

export default SliderThumb;
