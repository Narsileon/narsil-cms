import { Slider } from "@base-ui/react/slider";
import { cn } from "@narsil-cms/lib/utils";

function SliderControl({ className, ...props }: Slider.Control.Props) {
  return (
    <Slider.Control
      data-slot="slider-control"
      className={cn(
        "relative flex w-full touch-none items-center select-none",
        "data-disabled:opacity-50",
        "data-[orientation=vertical]:h-full data-[orientation=vertical]:min-h-40 data-[orientation=vertical]:w-auto data-[orientation=vertical]:flex-col",
      )}
      {...props}
    />
  );
}

export default SliderControl;
