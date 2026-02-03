import { Combobox } from "@base-ui/react";
import { Icon } from "@narsil-cms/components/icon";
import { InputGroupButton } from "@narsil-cms/components/input-group";
import { cn } from "@narsil-cms/lib/utils";

function ComboboxClear({ className, render, ...props }: Combobox.Clear.Props) {
  return (
    <Combobox.Clear
      data-slot="combobox-clear"
      className={cn(className)}
      {...props}
      render={
        render ?? (
          <InputGroupButton variant="ghost" size="icon-xs">
            <Icon className="pointer-events-none" name="x" />
          </InputGroupButton>
        )
      }
    />
  );
}

export default ComboboxClear;
