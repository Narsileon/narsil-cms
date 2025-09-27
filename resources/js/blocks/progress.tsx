import { type ComponentProps } from "react";

import {
  ProgressIndicator,
  ProgressRoot,
} from "@narsil-cms/components/progress";

type ProgressProps = ComponentProps<typeof ProgressRoot> & {
  indicatorProps?: Partial<ComponentProps<typeof ProgressIndicator>>;
};

function Progress({ indicatorProps, value, ...props }: ProgressProps) {
  const mergedIndicatorStyle = {
    ...indicatorProps?.style,
    transform: `translateX(-${100 - (value || 0)}%)`,
  };

  return (
    <ProgressRoot value={value} {...props}>
      <ProgressIndicator style={mergedIndicatorStyle} {...indicatorProps} />
    </ProgressRoot>
  );
}

export default Progress;
