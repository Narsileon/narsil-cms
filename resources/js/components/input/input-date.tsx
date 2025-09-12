import { useState } from "react";

import { Calendar } from "@narsil-cms/components/calendar";
import { Icon } from "@narsil-cms/components/icon";
import { Input } from "@narsil-cms/components/input";
import {
  PopoverContent,
  PopoverRoot,
  PopoverTrigger,
} from "@narsil-cms/components/popover";

type InputDateProps = Omit<React.ComponentProps<typeof Input>, "value"> & {
  value: string | undefined;
  onChange: (value: string | undefined) => void;
};

function InputDate({ value, onChange, ...props }: InputDateProps) {
  const [open, setOpen] = useState(false);

  const date = value ? new Date(value) : undefined;

  return (
    <PopoverRoot open={open} onOpenChange={setOpen}>
      <PopoverTrigger className="relative">
        <Input
          className="appearance-none [&::-webkit-calendar-picker-indicator]:hidden [&::-webkit-calendar-picker-indicator]:appearance-none"
          type="date"
          value={value}
          onChange={(event) => onChange(event.target.value)}
          {...props}
        />
        <Icon
          className="absolute top-1/2 right-2 -translate-y-1/2"
          name="calendar"
        />
      </PopoverTrigger>
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
    </PopoverRoot>
  );
}

export default InputDate;
