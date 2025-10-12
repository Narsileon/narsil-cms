import { cn } from "@narsil-cms/lib/utils";
import { Slider } from "radix-ui";
import { type ComponentProps } from "react";

type SliderRootProps = ComponentProps<typeof Slider.Root>;

function SliderRoot({
  className,
  defaultValue,
  min = 0,
  max = 100,
  value,
  ...props
}: SliderRootProps) {
  return (
    <Slider.Root
      data-slot="slider-root"
      defaultValue={defaultValue}
      value={value}
      min={min}
      max={max}
      className={cn(
        "relative flex h-9 w-full touch-none select-none items-center",
        "data-[disabled]:opacity-50",
        "data-[orientation=vertical]:h-full data-[orientation=vertical]:min-h-44 data-[orientation=vertical]:w-auto data-[orientation=vertical]:flex-col",
        className,
      )}
      {...props}
    />
  );
}

export default SliderRoot;
