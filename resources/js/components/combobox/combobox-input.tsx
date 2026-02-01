import { Combobox as ComboboxPrimitive } from "@base-ui/react";
import {
  InputGroup,
  InputGroupAddon,
  InputGroupButton,
  InputGroupInput,
} from "@narsil-cms/components/input-group";
import { cn } from "@narsil-cms/lib/utils";
import ComboboxClear from "./combobox-clear";
import ComboboxTrigger from "./combobox-trigger";

type ComboboxInputProps = ComboboxPrimitive.Input.Props & {
  showClear?: boolean;
  showTrigger?: boolean;
};

function ComboboxInput({
  children,
  className,
  disabled = false,
  showClear = false,
  showTrigger = true,
  ...props
}: ComboboxInputProps) {
  return (
    <InputGroup className={cn("w-auto", className)}>
      <ComboboxPrimitive.Input render={<InputGroupInput disabled={disabled} />} {...props} />
      <InputGroupAddon align="inline-end">
        {showTrigger && (
          <InputGroupButton
            data-slot="input-group-button"
            className="group-has-data-[slot=combobox-clear]/input-group:hidden data-pressed:bg-transparent"
            disabled={disabled}
            render={<ComboboxTrigger />}
            size="icon-xs"
            variant="ghost"
          />
        )}
        {showClear && <ComboboxClear disabled={disabled} />}
      </InputGroupAddon>
      {children}
    </InputGroup>
  );
}

export default ComboboxInput;
