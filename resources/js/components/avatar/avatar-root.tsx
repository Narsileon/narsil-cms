import { Avatar } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type AvatarRootProps = ComponentProps<typeof Avatar.Root> & {};

function AvatarRoot({ className, ...props }: AvatarRootProps) {
  return (
    <Avatar.Root
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
