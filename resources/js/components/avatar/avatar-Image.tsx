import { cn } from "@narsil-cms/lib/utils";
import { Avatar } from "radix-ui";
import { type ComponentProps } from "react";

type AvatarImageProps = ComponentProps<typeof Avatar.Image>;

function AvatarImage({ className, ...props }: AvatarImageProps) {
  return (
    <Avatar.Image
      data-slot="avatar-image"
      className={cn("aspect-square size-full", className)}
      {...props}
    />
  );
}

export default AvatarImage;
