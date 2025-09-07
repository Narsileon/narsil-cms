import * as React from "react";
import { AspectRatio as AspectRatioPrimitive } from "radix-ui";

type AspectRatioRootProps = React.ComponentProps<
  typeof AspectRatioPrimitive.Root
> & {};

function AspectRatioRoot({ ...props }: AspectRatioRootProps) {
  return <AspectRatioPrimitive.Root data-slot="aspect-ratio-root" {...props} />;
}

export default AspectRatioRoot;
