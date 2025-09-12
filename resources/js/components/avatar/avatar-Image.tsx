import { Avatar as AvatarPrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type AvatarImageProps = React.ComponentProps<typeof AvatarPrimitive.Image> & {};

function AvatarImage({ className, ...props }: AvatarImageProps) {
  return (
    <AvatarPrimitive.Image
      data-slot="avatar-image"
      className={cn("aspect-square size-full", className)}
      {...props}
    />
  );
}

export default AvatarImage;
