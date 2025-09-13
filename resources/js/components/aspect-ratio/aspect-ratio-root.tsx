import { AspectRatio } from "radix-ui";

type AspectRatioRootProps = React.ComponentProps<typeof AspectRatio.Root> & {};

function AspectRatioRoot({ ...props }: AspectRatioRootProps) {
  return <AspectRatio.Root data-slot="aspect-ratio-root" {...props} />;
}

export default AspectRatioRoot;
