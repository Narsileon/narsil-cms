import { Calendar } from "@narsil-cms/blocks/calendar";
import { Icon } from "@narsil-cms/blocks/icon";
import { InputContent } from "@narsil-cms/components/input";
import { InputGroup, InputGroupAddon, InputGroupInput } from "@narsil-cms/components/input-group";
import {
  PopoverPopup,
  PopoverPortal,
  PopoverPositioner,
  PopoverRoot,
  PopoverTrigger,
} from "@narsil-cms/components/popover";
import { cn } from "@narsil-cms/lib/utils";
import { useState, type ComponentProps } from "react";

type DatetimeProps = Omit<ComponentProps<typeof InputContent>, "value"> & {
  value: string | undefined;
  onChange: (value: string | undefined) => void;
};

function Datetime({ value, onChange, ...props }: DatetimeProps) {
  const [open, setOpen] = useState(false);

  const date = value ? new Date(value) : undefined;

  return (
    <PopoverRoot open={open} onOpenChange={setOpen}>
      <PopoverTrigger
        className="relative"
        render={
          <InputGroup className={cn(open && "border-shine")}>
            <InputGroupInput
              className={cn(!value && "opacity-50")}
              type="date"
              value={value}
              onChange={(event) => onChange(event.target.value)}
              {...props}
            />
            <InputGroupAddon align="inline-end">
              <Icon className="opacity-50" name="calendar" />
            </InputGroupAddon>
          </InputGroup>
        }
      />
      <PopoverPortal>
        <PopoverPositioner align="start">
          <PopoverPopup className="w-auto overflow-hidden p-0">
            <Calendar
              captionLayout="dropdown"
              mode="single"
              defaultMonth={date}
              selected={date}
              onSelect={(selected) => {
                const newValue = selected ? selected.toLocaleDateString("en-CA") : undefined;
                onChange?.(newValue);
                setOpen(false);
              }}
            />
          </PopoverPopup>
        </PopoverPositioner>
      </PopoverPortal>
    </PopoverRoot>
  );
}

export default Datetime;
