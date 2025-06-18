import { cn } from "@/Components";
import { Fallback } from "@radix-ui/react-avatar";

export type AvatarFallbackProps = React.ComponentProps<typeof Fallback> & {};

function AvatarFallback({ className, ...props }: AvatarFallbackProps) {
  return (
    <Fallback
      className={cn(
        "bg-muted flex size-full items-center justify-center rounded-full",
        className,
      )}
      data-slot="avatar-fallback"
      {...props}
    />
  );
}

export default AvatarFallback;
