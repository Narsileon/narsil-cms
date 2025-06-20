import { cn } from "@/components";
import { Image } from "@radix-ui/react-avatar";

export type AvatarImageProps = React.ComponentProps<typeof Image> & {};

function AvatarImage({ className, ...props }: AvatarImageProps) {
  return (
    <Image
      data-slot="avatar-image"
      className={cn("aspect-square size-full", className)}
      {...props}
    />
  );
}

export default AvatarImage;
