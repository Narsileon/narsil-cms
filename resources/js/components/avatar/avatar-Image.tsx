import { Avatar } from "@base-ui/react/avatar";
import { cn } from "@narsil-cms/lib/utils";

function AvatarImage({ className, ...props }: Avatar.Image.Props) {
  return (
    <Avatar.Image
      data-slot="avatar-image"
      className={cn("aspect-square size-full rounded-full object-cover", className)}
      {...props}
    />
  );
}

export default AvatarImage;
