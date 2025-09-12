import { Slider as SliderPrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type SliderRootProps = React.ComponentProps<typeof SliderPrimitive.Root> & {};

function SliderRoot({
  className,
  defaultValue,
  value,
  min = 0,
  max = 100,
  ...props
}: SliderRootProps) {
  return (
    <SliderPrimitive.Root
      data-slot="slider-root"
      defaultValue={defaultValue}
      value={value}
      min={min}
      max={max}
      className={cn(
        "relative flex h-9 w-full touch-none items-center select-none",
        "data-[disabled]:opacity-50",
        "data-[orientation=vertical]:h-full data-[orientation=vertical]:min-h-44 data-[orientation=vertical]:w-auto data-[orientation=vertical]:flex-col",
        className,
      )}
      {...props}
    />
  );
}

export default SliderRoot;
