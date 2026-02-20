import { Button } from "@narsil-ui/components/button";
import { Calendar } from "@narsil-ui/components/calendar";
import { Icon } from "@narsil-ui/components/icon";
import { InputContent } from "@narsil-ui/components/input";
import {
  InputGroupAddon,
  InputGroupInput,
  InputGroupRoot,
} from "@narsil-ui/components/input-group";
import {
  PopoverPopup,
  PopoverPortal,
  PopoverPositioner,
  PopoverRoot,
  PopoverTrigger,
} from "@narsil-ui/components/popover";
import { Separator } from "@narsil-ui/components/separator";
import { cn } from "@narsil-ui/lib/utils";
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
      <PopoverTrigger
        className="relative basis-1/2"
        render={
          <InputGroupRoot className={cn(open && "border-shine")}>
            <InputGroupInput
              className={cn(!value && "opacity-50")}
              value={value}
              onChange={(event) => onChange(event.target.value)}
              {...props}
            />
            <InputGroupAddon align="inline-end">
              <Icon className="opacity-50" name="calendar" />
            </InputGroupAddon>
          </InputGroupRoot>
        }
      />
      <PopoverPortal>
        <PopoverPositioner align="start">
          <PopoverPopup className="flex max-h-fit max-w-62 flex-col items-center overflow-hidden p-0">
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
                {hours.map((h) => (
                  <Button
                    className="aspect-square shrink-0"
                    disabled={!date}
                    size="icon-sm"
                    variant={date && hour === h ? "primary" : "ghost"}
                    onClick={() => updateTime(h, minute ?? 0)}
                    key={h}
                  >
                    {h}
                  </Button>
                ))}
              </div>
              <div className="no-scrollbar flex gap-1 overflow-x-auto" onWheel={onWheel}>
                {minutes.map((m) => (
                  <Button
                    className="aspect-square shrink-0"
                    disabled={!date}
                    size="icon-sm"
                    variant={date && minute === Number(m) ? "primary" : "ghost"}
                    onClick={() => updateTime(hour ?? 0, Number(m))}
                    key={m}
                  >
                    {m}
                  </Button>
                ))}
              </div>
            </div>
          </PopoverPopup>
        </PopoverPositioner>
      </PopoverPortal>
    </PopoverRoot>
  );
}

export default Datetime;
