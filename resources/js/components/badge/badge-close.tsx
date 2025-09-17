import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";
import { type IconName } from "@narsil-cms/plugins/icons";

type BadgeCloseProps = React.ComponentProps<"button"> & {
  icon?: IconName;
};

function BadgeClose({ className, icon = "x", ...props }: BadgeCloseProps) {
  return (
    <button
      data-slot="badge-close"
      className={cn("cursor-pointer hover:text-destructive", className)}
      type="button"
      {...props}
    >
      <Icon className="size-3" name={icon} />
    </button>
  );
}

export default BadgeClose;
