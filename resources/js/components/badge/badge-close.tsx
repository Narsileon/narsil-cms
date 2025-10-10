import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";
import { type IconName } from "@narsil-cms/plugins/icons";
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
      <Icon className="hover:text-destructive size-3.5 text-current" name={icon} />
    </button>
  );
}

export default BadgeClose;
