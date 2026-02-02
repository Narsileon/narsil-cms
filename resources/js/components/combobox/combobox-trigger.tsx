import { Combobox } from "@base-ui/react";
import { Icon } from "@narsil-cms/blocks/icon";
import { cn } from "@narsil-cms/lib/utils";

function ComboboxTrigger({ children, className, ...props }: Combobox.Trigger.Props) {
  return (
    <Combobox.Trigger
      data-slot="combobox-trigger"
      className={cn("[&_svg:not([class*='size-'])]:size-4", className)}
      {...props}
    >
      {children}
      <Icon className="pointer-events-none size-4 text-muted-foreground" name="chevron-down" />
    </Combobox.Trigger>
  );
}

export default ComboboxTrigger;
