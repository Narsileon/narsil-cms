import { cn } from "@/components";
import { Fallback } from "@radix-ui/react-avatar";

export type AvatarFallbackProps = React.ComponentProps<typeof Fallback> & {};

function AvatarFallback({ className, ...props }: AvatarFallbackProps) {
  return (
    <Fallback
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
