import { Avatar } from "@base-ui/react/avatar";
import { cn } from "@narsil-cms/lib/utils";

function AvatarFallback({ className, ...props }: Avatar.Fallback.Props) {
  return (
    <Avatar.Fallback
      data-slot="avatar-fallback"
      className={cn(
        "flex size-full items-center justify-center rounded-full bg-muted text-sm text-muted-foreground",
        "group-data-[size=sm]/avatar:text-xs",
        className,
      )}
      {...props}
    />
  );
}

export default AvatarFallback;
