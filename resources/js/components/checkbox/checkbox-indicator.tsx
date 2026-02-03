import { Checkbox } from "@base-ui/react/checkbox";
import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";

function CheckboxIndicator({ className, children, ...props }: Checkbox.Indicator.Props) {
  return (
    <Checkbox.Indicator
      data-slot="checkbox-indicator"
      className={cn(
        "grid place-content-center text-current transition-none [&>svg]:size-3.5",
        className,
      )}
      {...props}
    >
      {children ?? <Icon className="size-3.5 text-current" name="check" />}
    </Checkbox.Indicator>
  );
}

export default CheckboxIndicator;
