import { Slider } from "@base-ui/react/slider";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type SliderTrackProps = ComponentProps<typeof Slider.Track>;

function SliderTrack({ className, ...props }: SliderTrackProps) {
  return (
    <Slider.Track
      data-slot="slider-track"
      className={cn(
        "relative grow overflow-hidden rounded-full bg-muted select-none",
        "data-horizontal:h-1 data-horizontal:w-full",
        "data-vertical:h-full data-vertical:w-1",
        className,
      )}
      {...props}
    />
  );
}

export default SliderTrack;
