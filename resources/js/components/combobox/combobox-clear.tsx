import { Combobox } from "@base-ui/react";
import { InputGroupButton } from "@narsil-cms/components/input-group";
import { cn } from "@narsil-cms/lib/utils";
import { XIcon } from "lucide-react";

function ComboboxClear({ className, render, ...props }: Combobox.Clear.Props) {
  return (
    <Combobox.Clear
      data-slot="combobox-clear"
      className={cn(className)}
      {...props}
      render={
        render ?? (
          <InputGroupButton variant="ghost" size="icon-xs">
            <XIcon className="pointer-events-none" />
          </InputGroupButton>
        )
      }
    />
  );
}

export default ComboboxClear;
