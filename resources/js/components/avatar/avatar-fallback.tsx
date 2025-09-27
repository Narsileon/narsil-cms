import { Avatar } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type AvatarFallbackProps = ComponentProps<typeof Avatar.Fallback> & {};
function AvatarFallback({ className, ...props }: AvatarFallbackProps) {
  return (
    <Avatar.Fallback
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
