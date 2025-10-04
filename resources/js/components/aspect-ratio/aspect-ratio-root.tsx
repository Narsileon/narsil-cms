import { AspectRatio } from "radix-ui";
import { type ComponentProps } from "react";

type AspectRatioRootProps = ComponentProps<typeof AspectRatio.Root>;

function AspectRatioRoot({ ...props }: AspectRatioRootProps) {
  return <AspectRatio.Root data-slot="aspect-ratio-root" {...props} />;
}

export default AspectRatioRoot;
