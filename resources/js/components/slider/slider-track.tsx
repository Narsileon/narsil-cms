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
        "data-[orientation=horizontal]:h-2 data-[orientation=horizontal]:w-full",
        "data-[orientation=vertical]:h-full data-[orientation=vertical]:w-2",
        className,
      )}
      {...props}
    />
  );
}

export default SliderTrack;
