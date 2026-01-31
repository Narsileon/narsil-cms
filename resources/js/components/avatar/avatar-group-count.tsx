import { cn } from "@narsil-cms/lib/utils";
import { ComponentProps } from "react";

function AvatarGroupCount({ className, ...props }: ComponentProps<"div">) {
  return (
    <div
      data-slot="avatar-group-count"
      className={cn(
        "relative flex size-8 shrink-0 items-center justify-center rounded-full bg-muted text-sm text-muted-foreground ring-2 ring-background",
        "group-has-data-[size=lg]/avatar-group:size-10",
        "group-has-data-[size=sm]/avatar-group:size-6",
        "[&>svg]:size-4",
        "group-has-data-[size=lg]/avatar-group:[&>svg]:size-5",
        "group-has-data-[size=sm]/avatar-group:[&>svg]:size-3",
        className,
      )}
      {...props}
    />
  );
}

export default AvatarGroupCount;
