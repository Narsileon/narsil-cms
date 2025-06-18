import { cn } from "@/Components";
import { Image } from "@radix-ui/react-avatar";

export type AvatarImageProps = React.ComponentProps<typeof Image> & {};

function AvatarImage({ className, ...props }: AvatarImageProps) {
  return (
    <Image
      className={cn("aspect-square size-full", className)}
      data-slot="avatar-image"
      {...props}
    />
  );
}

export default AvatarImage;
