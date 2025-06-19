import { cn } from "@/Components";
import { Root } from "@radix-ui/react-avatar";

export type AvatarProps = React.ComponentProps<typeof Root> & {};

function Avatar({ className, ...props }: AvatarProps) {
  return (
    <Root
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
