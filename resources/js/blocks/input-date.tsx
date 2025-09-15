import { useState } from "react";

import { Calendar } from "@narsil-cms/components/calendar";
import { Icon } from "@narsil-cms/components/icon";
import { InputContent, InputRoot } from "@narsil-cms/components/input";
import {
  PopoverContent,
  PopoverPortal,
  PopoverRoot,
  PopoverTrigger,
} from "@narsil-cms/components/popover";
import { cn } from "@narsil-cms/lib/utils";

type InputDateProps = Omit<
  React.ComponentProps<typeof InputContent>,
  "value"
> & {
  value: string | undefined;
  onChange: (value: string | undefined) => void;
};

function InputDate({ value, onChange, ...props }: InputDateProps) {
  const [open, setOpen] = useState(false);

  const date = value ? new Date(value) : undefined;

  return (
    <PopoverRoot open={open} onOpenChange={setOpen}>
      <PopoverTrigger className="relative" asChild>
        <InputRoot variant="button">
          <InputContent
            className={cn(!value && "opacity-50")}
            type="date"
            value={value}
            onChange={(event) => onChange(event.target.value)}
            {...props}
          />
          <Icon className="opacity-50" name="calendar" />
        </InputRoot>
      </PopoverTrigger>
      <PopoverPortal>
        <PopoverContent className="w-auto overflow-hidden p-0" align="start">
          <Calendar
            captionLayout="dropdown"
            mode="single"
            defaultMonth={date}
            selected={date}
            onSelect={(selected) => {
              const newValue = selected
                ? selected.toLocaleDateString("en-CA")
                : undefined;
              onChange?.(newValue);
              setOpen(false);
            }}
          />
        </PopoverContent>
      </PopoverPortal>
    </PopoverRoot>
  );
}

export default InputDate;
