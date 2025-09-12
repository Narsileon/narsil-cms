import { Avatar as AvatarPrimitive } from "radix-ui";
import { cn } from "@narsil-cms/lib/utils";

type AvatarRootProps = React.ComponentProps<typeof AvatarPrimitive.Root> & {};

function AvatarRoot({ className, ...props }: AvatarRootProps) {
  return (
    <AvatarPrimitive.Root
      data-slot="avatar-root"
      className={cn(
        "relative flex size-9 shrink-0 overflow-hidden rounded-full",
        className,
      )}
      {...props}
    />
  );
}

export default AvatarRoot;
