import { Slider } from "@base-ui/react/slider";
import { cn } from "@narsil-cms/lib/utils";

function SliderControl({ className, ...props }: Slider.Control.Props) {
  return (
    <Slider.Control
      data-slot="slider-control"
      className={cn(
        "relative flex w-full touch-none items-center select-none",
        "data-disabled:opacity-50",
        "data-vertical:h-full data-vertical:min-h-40 data-vertical:w-auto data-vertical:flex-col",
      )}
      {...props}
    />
  );
}

export default SliderControl;
