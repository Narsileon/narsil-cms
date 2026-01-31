import { Slider } from "@base-ui/react/slider";
import { cn } from "@narsil-cms/lib/utils";

function SliderRoot({
  className,
  min = 0,
  max = 100,
  thumbAlignment = "edge",
  ...props
}: Slider.Root.Props) {
  return (
    <Slider.Root
      data-slot="slider-root"
      className={cn(
        "flex h-6 flex-col justify-center",
        "data-[orientation=horizontal]:w-full data-[orientation=vertical]:h-full",
        className,
      )}
      min={min}
      max={max}
      thumbAlignment={thumbAlignment}
      {...props}
    />
  );
}

export default SliderRoot;
