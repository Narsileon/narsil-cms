import { Switch } from "@base-ui/react/switch";
import { cn } from "@narsil-cms/lib/utils";

function SwitchThumb({ className, ...props }: Switch.Thumb.Props) {
  return (
    <Switch.Thumb
      data-slot="switch-thumb"
      className={cn(
        "pointer-events-none block rounded-full bg-background ring-0 transition-transform will-change-transform",
        "dark:data-checked:bg-foreground",
        "dark:data-unchecked:bg-foreground",
        "group-data-[size=default]/switch:data-checked:translate-x-[calc(100%)]",
        "group-data-[size=default]/switch:data-unchecked:translate-x-0",
        "group-data-[size=default]/switch:size-4",
        "group-data-[size=sm]/switch:data-checked:translate-x-[calc(100%)]",
        "group-data-[size=sm]/switch:data-unchecked:translate-x-0",
        "group-data-[size=sm]/switch:size-3",
        className,
      )}
      {...props}
    />
  );
}

export default SwitchThumb;
