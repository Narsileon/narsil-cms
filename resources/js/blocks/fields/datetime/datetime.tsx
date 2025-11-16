import { Button, Calendar, Separator } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { InputContent, InputRoot } from "@narsil-cms/components/input";
import {
  PopoverContent,
  PopoverPortal,
  PopoverRoot,
  PopoverTrigger,
} from "@narsil-cms/components/popover";
import { cn } from "@narsil-cms/lib/utils";
import { useMemo, useState, type ComponentProps, type WheelEvent } from "react";

type DatetimeProps = Omit<ComponentProps<typeof InputContent>, "value"> & {
  value: string | undefined;
  onChange: (value: string | undefined) => void;
};

function Datetime({ value, onChange, ...props }: DatetimeProps) {
  const [open, setOpen] = useState(false);

  const normalized = value ? value.replace(" ", "T").slice(0, 16) : undefined;

  const datePart = normalized?.split("T")[0] ?? "";
  const timePart = normalized?.split("T")[1] ?? "00:00";

  const [hour, minute] = timePart.split(":").map(Number);

  const date = value ? new Date(datePart) : undefined;

  const hours = useMemo(() => {
    return Array.from({ length: 24 }, (_, index) => index + 1);
  }, []);

  const minutes = useMemo(() => {
    return Array.from({ length: 60 }, (_, index) => index.toString().padStart(2, "0"));
  }, []);

  function onWheel(event: WheelEvent) {
    const element = event.currentTarget;
    if (event.deltaY === 0) {
      return;
    }

    event.preventDefault();

    element.scrollTo({
      left: element.scrollLeft + event.deltaY * 2,
      behavior: "smooth",
    });
  }

  function updateTime(newHour: number, newMinute: number) {
    if (!datePart) {
      return;
    }

    const h = String(newHour).padStart(2, "0");
    const m = String(newMinute).padStart(2, "0");

    onChange(`${datePart}T${h}:${m}`);
  }

  return (
    <PopoverRoot open={open} onOpenChange={setOpen}>
      <PopoverTrigger className="relative basis-1/2" asChild>
        <InputRoot className={cn(open && "border-shine")} variant="button">
          <InputContent
            className={cn(!value && "opacity-50")}
            value={value}
            onChange={(event) => onChange(event.target.value)}
            {...props}
          />
          <Icon className="opacity-50" name="calendar" />
        </InputRoot>
      </PopoverTrigger>
      <PopoverPortal>
        <PopoverContent
          className="flex max-h-fit max-w-62 flex-col items-center overflow-hidden p-0"
          align="start"
        >
          <Calendar
            captionLayout="dropdown"
            mode="single"
            defaultMonth={date}
            selected={date}
            onSelect={(selected) => {
              const newDate = selected ? selected.toLocaleDateString("en-CA") : undefined;

              const h = String(hour ?? 0).padStart(2, "0");
              const m = String(minute ?? 0).padStart(2, "0");

              onChange(`${newDate}T${h}:${m}`);
            }}
          />
          <Separator />
          <div className="grid w-full gap-2 p-4">
            <div className="no-scrollbar flex gap-1 overflow-x-auto" onWheel={onWheel}>
              {hours.map((hour) => (
                <Button
                  className="aspect-square shrink-0"
                  disabled={!date}
                  size="icon-sm"
                  variant={date && date.getHours() === hour ? "primary" : "ghost"}
                  key={hour}
                  onClick={() => updateTime(hour, minute ?? 0)}
                >
                  {hour}
                </Button>
              ))}
            </div>
            <div className="no-scrollbar flex gap-1 overflow-x-auto" onWheel={onWheel}>
              {minutes.map((minute) => (
                <Button
                  className="aspect-square shrink-0"
                  disabled={!date}
                  size="icon-sm"
                  variant={date && date.getMinutes() === Number(minute) ? "primary" : "ghost"}
                  onClick={() => updateTime(hour ?? 0, Number(minute))}
                >
                  {minute}
                </Button>
              ))}
            </div>
          </div>
        </PopoverContent>
      </PopoverPortal>
    </PopoverRoot>
  );
}

export default Datetime;
