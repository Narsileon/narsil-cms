import * as React from "react";
import { Calendar } from "@narsil-cms/components/ui/calendar";
import { Icon } from "@narsil-cms/components/ui/icon";
import { Input } from "@narsil-cms/components/ui/input";
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from "@narsil-cms/components/ui/popover";

type InputDateProps = Omit<React.ComponentProps<typeof Input>, "value"> & {
  value: string | undefined;
  onChange: (value: string | undefined) => void;
};

function InputDate({ placeholder, value, onChange, ...props }: InputDateProps) {
  const [open, setOpen] = React.useState(false);

  const date = value ? new Date(value) : undefined;

  return (
    <Popover open={open} onOpenChange={setOpen}>
      <PopoverTrigger className="relative">
        <Input
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
    </Popover>
  );
}

export default InputDate;
