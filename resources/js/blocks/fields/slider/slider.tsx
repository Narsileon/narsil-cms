import { SliderRange, SliderRoot, SliderThumb, SliderTrack } from "@narsil-cms/components/slider";
import { useMemo, type ComponentProps } from "react";

type SliderProps = ComponentProps<typeof SliderRoot>;

function Slider({ defaultValue, value, min = 0, max = 100, ...props }: SliderProps) {
  const computedValue = useMemo(() => {
    return Array.isArray(value) ? value : Array.isArray(defaultValue) ? defaultValue : [min, max];
  }, [value, defaultValue, min, max]);

  return (
    <SliderRoot defaultValue={defaultValue} value={value} min={min} max={max} {...props}>
      <SliderTrack>
        <SliderRange />
      </SliderTrack>
      {Array.from({ length: computedValue.length }, (_, index) => {
        return <SliderThumb key={index} />;
      })}
    </SliderRoot>
  );
}

export default Slider;
