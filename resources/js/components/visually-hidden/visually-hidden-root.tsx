import { VisuallyHidden } from "radix-ui";
import { type ComponentProps } from "react";

type VisuallyHiddenRootProps = ComponentProps<typeof VisuallyHidden.Root>;

function VisuallyHiddenRoot({
  asChild = false,
  ...props
}: VisuallyHiddenRootProps) {
  return (
    <VisuallyHidden.Root
      data-slot="visually-hidden-root"
      asChild={asChild}
      {...props}
    />
  );
}

export default VisuallyHiddenRoot;
