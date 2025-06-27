import { VisuallyHidden as VisuallyHiddenPrimitive } from "radix-ui";

export type VisuallyHiddenProps = React.ComponentProps<
  typeof VisuallyHiddenPrimitive.Root
> & {};

function VisuallyHidden({ asChild = false, ...props }: VisuallyHiddenProps) {
  return (
    <VisuallyHiddenPrimitive.Root data-slot="visually-hidden" {...props} />
  );
}

export default VisuallyHidden;
