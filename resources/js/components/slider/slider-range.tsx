import { Slider as SliderPrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type SliderRangeProps = React.ComponentProps<typeof SliderPrimitive.Range> & {};

function SliderRange({ className, ...props }: SliderRangeProps) {
  return (
    <SliderPrimitive.Range
      data-slot="slider-range"
      className={cn(
        "absolute bg-primary",
        "data-[orientation=horizontal]:h-full",
        "data-[orientation=vertical]:w-full",
        className,
      )}
      {...props}
    />
  );
}

export default SliderRange;
