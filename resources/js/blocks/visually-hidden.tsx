import { VisuallyHiddenRoot } from "@narsil-cms/components/visually-hidden";
import { type ComponentProps } from "react";

type VisuallyHiddenProps = ComponentProps<typeof VisuallyHiddenRoot>;

function VisuallyHidden({ ...props }: VisuallyHiddenProps) {
  return <VisuallyHiddenRoot {...props} />;
}

export default VisuallyHidden;
