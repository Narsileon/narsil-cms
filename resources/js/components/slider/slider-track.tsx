import { cn } from "@narsil-cms/lib/utils";
import { Slider } from "radix-ui";
import { type ComponentProps } from "react";

type SliderTrackProps = ComponentProps<typeof Slider.Track>;

function SliderTrack({ className, ...props }: SliderTrackProps) {
  return (
    <Slider.Track
      data-slot="slider-track"
      className={cn(
        "bg-muted relative grow overflow-hidden rounded-full",
        "data-[orientation=horizontal]:h-1.5 data-[orientation=horizontal]:w-full",
        "data-[orientation=vertical]:h-full data-[orientation=vertical]:w-1.5",
        className,
      )}
      {...props}
    />
  );
}

export default SliderTrack;
