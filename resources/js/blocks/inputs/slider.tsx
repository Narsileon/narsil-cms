import { useMemo } from "react";

import {
  SliderRange,
  SliderRoot,
  SliderThumb,
  SliderTrack,
} from "@narsil-cms/components/slider";

type SliderProps = React.ComponentProps<typeof SliderRoot> & {};

function Slider({
  defaultValue,
  value,
  min = 0,
  max = 100,
  ...props
}: SliderProps) {
  const _values = useMemo(
    () =>
      Array.isArray(value)
        ? value
        : Array.isArray(defaultValue)
          ? defaultValue
          : [min, max],
    [value, defaultValue, min, max],
  );
  return (
    <SliderRoot
      defaultValue={defaultValue}
      value={value}
      min={min}
      max={max}
      {...props}
    >
      <SliderTrack>
        <SliderRange />
      </SliderTrack>
      {Array.from({ length: _values.length }, (_, index) => (
        <SliderThumb key={index} />
      ))}
    </SliderRoot>
  );
}

export default Slider;
