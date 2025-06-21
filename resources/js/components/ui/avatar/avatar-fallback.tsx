import { Avatar as AvatarPrimitive } from "radix-ui";
import { cn } from "@/components";

export type AvatarFallbackProps = React.ComponentProps<
  typeof AvatarPrimitive.Fallback
> & {};

function AvatarFallback({ className, ...props }: AvatarFallbackProps) {
  return (
    <AvatarPrimitive.Fallback
      data-slot="avatar-fallback"
      className={cn(
        "bg-muted flex size-full items-center justify-center rounded-full",
        className,
      )}
      {...props}
    />
  );
}

export default AvatarFallback;
