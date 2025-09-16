import { AspectRatioRoot } from "@narsil-cms/components/aspect-ratio";

type AspectRatioProps = React.ComponentProps<typeof AspectRatioRoot> & {};

function AspectRatio({ ...props }: AspectRatioProps) {
  return <AspectRatioRoot {...props} />;
}

export default AspectRatio;
