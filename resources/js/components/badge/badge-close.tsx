import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";
import { type IconName } from "@narsil-cms/registries/icons";
import { type ComponentProps } from "react";

type BadgeCloseProps = ComponentProps<"button"> & {
  icon?: IconName;
};

function BadgeClose({ className, icon = "x", ...props }: BadgeCloseProps) {
  return (
    <button
      data-slot="badge-close"
      className={cn("cursor-pointer", className)}
      type="button"
      {...props}
    >
      <Icon className="size-3.5 text-current hover:text-destructive" name={icon} />
    </button>
  );
}

export default BadgeClose;
