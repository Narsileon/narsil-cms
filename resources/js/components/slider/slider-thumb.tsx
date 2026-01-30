import { Slider } from "@base-ui/react/slider";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type SliderThumbProps = ComponentProps<typeof Slider.Thumb>;

function SliderThumb({ className, ...props }: SliderThumbProps) {
  return (
    <Slider.Thumb
      data-slot="slider-thumb"
      className={cn(
        "relative block size-3 shrink-0 rounded-full border border-ring bg-white ring-ring/50 transition-[color,box-shadow] select-none",
        "active:ring-[3px]",
        "after:absolute after:-inset-2",
        "disabled:pointer-events-none disabled:opacity-50",
        "focus-visible:ring-[3px] focus-visible:outline-hidden",
        "hover:ring-[3px]",
        className,
      )}
      {...props}
    />
  );
}

export default SliderThumb;
