import { Avatar as AvatarPrimitive } from "radix-ui";
import { cn } from "@narsil-cms/lib/utils";

type AvatarFallbackProps = React.ComponentProps<
  typeof AvatarPrimitive.Fallback
> & {};

function AvatarFallback({ className, ...props }: AvatarFallbackProps) {
  return (
    <AvatarPrimitive.Fallback
      data-slot="avatar-fallback"
      className={cn(
        "flex size-full items-center justify-center rounded-full bg-muted",
        className,
      )}
      {...props}
    />
  );
}

export default AvatarFallback;
