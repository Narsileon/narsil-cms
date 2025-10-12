import { AspectRatioRoot } from "@narsil-cms/components/aspect-ratio";
import { type ComponentProps } from "react";

type AspectRatioProps = ComponentProps<typeof AspectRatioRoot>;

function AspectRatio({ ...props }: AspectRatioProps) {
  return <AspectRatioRoot {...props} />;
}

export default AspectRatio;
