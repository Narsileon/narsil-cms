import { VisuallyHidden as VisuallyHiddenPrimitive } from "radix-ui";

type VisuallyHiddenRootProps = React.ComponentProps<
  typeof VisuallyHiddenPrimitive.Root
> & {};

function VisuallyHiddenRoot({
  asChild = false,
  ...props
}: VisuallyHiddenRootProps) {
  return (
    <VisuallyHiddenPrimitive.Root
      data-slot="visually-hidden-root"
      asChild={asChild}
      {...props}
    />
  );
}

export default VisuallyHiddenRoot;
