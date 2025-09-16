import { VisuallyHiddenRoot } from "@narsil-cms/components/visually-hidden";

type VisuallyHiddenProps = React.ComponentProps<typeof VisuallyHiddenRoot> & {};

function VisuallyHidden({ ...props }: VisuallyHiddenProps) {
  return <VisuallyHiddenRoot {...props} />;
}

export default VisuallyHidden;
