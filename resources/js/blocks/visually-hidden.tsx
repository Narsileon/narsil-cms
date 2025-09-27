import { type ComponentProps } from "react";

import { VisuallyHiddenRoot } from "@narsil-cms/components/visually-hidden";

type VisuallyHiddenProps = ComponentProps<typeof VisuallyHiddenRoot> & {};

function VisuallyHidden({ ...props }: VisuallyHiddenProps) {
  return <VisuallyHiddenRoot {...props} />;
}

export default VisuallyHidden;
