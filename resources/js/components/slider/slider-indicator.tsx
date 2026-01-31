import { Slider } from "@base-ui/react/slider";
import { cn } from "@narsil-cms/lib/utils";

function SliderIndicator({ className, ...props }: Slider.Indicator.Props) {
  return (
    <Slider.Indicator
      data-slot="slider-indicator"
      className={cn(
        "bg-primary select-none",
        "data-[orientation=horizontal]:h-full",
        "data-[orientation=vertical]:w-full",
        className,
      )}
      {...props}
    />
  );
}

export default SliderIndicator;
