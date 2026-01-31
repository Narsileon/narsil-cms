import { Avatar } from "@base-ui/react/avatar";
import { cn } from "@narsil-cms/lib/utils";

function AvatarRoot({ className, ...props }: Avatar.Root.Props) {
  return (
    <Avatar.Root
      data-slot="avatar-root"
      className={cn(
        "group/avatar",
        "relative flex size-8 shrink-0 rounded-full select-none",
        "after:absolute after:inset-0 after:rounded-full after:border after:border-border after:mix-blend-darken",
        "dark:after:mix-blend-lighten",
        "data-[size=lg]:size-10",
        "data-[size=sm]:size-6",
        className,
      )}
      {...props}
    />
  );
}

export default AvatarRoot;
