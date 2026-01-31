import { cn } from "@narsil-cms/lib/utils";
import { ComponentProps } from "react";

function AvatarBadge({ className, ...props }: ComponentProps<"span">) {
  return (
    <span
      data-slot="avatar-badge"
      className={cn(
        "absolute right-0 bottom-0 z-10 inline-flex items-center justify-center rounded-full bg-primary text-primary-foreground bg-blend-color ring-2 ring-background select-none",
        "group-data-[size=default]/avatar:[&>svg]:size-2",
        "group-data-[size=default]/avatar:size-2.5",
        "group-data-[size=lg]/avatar:[&>svg]:size-2",
        "group-data-[size=lg]/avatar:size-3",
        "group-data-[size=sm]/avatar:[&>svg]:hidden",
        "group-data-[size=sm]/avatar:size-2",
        className,
      )}
      {...props}
    />
  );
}

export default AvatarBadge;
