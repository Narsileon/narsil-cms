import { Root } from "@radix-ui/react-aspect-ratio";

export type AspectRatioProps = React.ComponentProps<typeof Root> & {};

function AspectRatio({ ...props }: AspectRatioProps) {
  return <Root data-slot="aspect-ratio" {...props} />;
}

export default AspectRatio;
