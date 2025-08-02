import { Button } from "@narsil-cms/components/ui/button";
import { Calendar } from "@narsil-cms/components/ui/calendar";
import { ChevronDownIcon } from "lucide-react";
import { isValid, parseISO } from "date-fns";
import { Input } from "@narsil-cms/components/ui/input";
import { useState } from "react";
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
  const [open, setOpen] = useState(false);

  const date = value ? parseISO(value) : undefined;
  const validity = date && isValid(date);

  return (
    <Popover open={open} onOpenChange={setOpen}>
      <PopoverTrigger asChild>
        <Button
          variant="outline"
          id="date-picker"
          className="w-full justify-between font-normal"
        >
          {validity ? date.toLocaleDateString() : placeholder}
          <ChevronDownIcon className="size-5" />
        </Button>
      </PopoverTrigger>
      <PopoverContent className="w-auto overflow-hidden p-0" align="start">
        <Calendar
          captionLayout="dropdown"
          mode="single"
          selected={date}
          onSelect={(selected) => {
            const newValue = selected
              ? selected.toISOString().split("T")[0]
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
