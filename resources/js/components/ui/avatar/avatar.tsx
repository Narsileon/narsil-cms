import * as React from "react";
import { Avatar as AvatarPrimitive } from "radix-ui";
import { cn } from "@narsil-cms/lib/utils";

type AvatarProps = React.ComponentProps<typeof AvatarPrimitive.Root> & {};

function Avatar({ className, ...props }: AvatarProps) {
  return (
    <AvatarPrimitive.Root
      data-slot="avatar"
      className={cn(
        "relative flex size-8 shrink-0 overflow-hidden rounded-full",
        className,
      )}
      {...props}
    />
  );
}

export default Avatar;
