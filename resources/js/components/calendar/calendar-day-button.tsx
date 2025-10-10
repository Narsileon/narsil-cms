import { Button } from "@narsil-cms/blocks";
import { cn } from "@narsil-cms/lib/utils";
import { useEffect, useRef, type ComponentProps } from "react";
import { DayButton, getDefaultClassNames } from "react-day-picker";

type CalendarDayButtonProps = ComponentProps<typeof DayButton>;

function CalendarDayButton({ className, day, modifiers, ...props }: CalendarDayButtonProps) {
  const ref = useRef<HTMLButtonElement>(null);

  const defaultClassNames = getDefaultClassNames();

  useEffect(() => {
    if (modifiers.focused) ref.current?.focus();
  }, [modifiers.focused]);

  return (
    <Button
      ref={ref}
      data-slot="calendar-day-button"
      data-day={day.date.toLocaleDateString()}
      data-range-end={modifiers.range_end}
      data-range-middle={modifiers.range_middle}
      data-range-start={modifiers.range_start}
      data-selected-single={
        modifiers.selected &&
        !modifiers.range_start &&
        !modifiers.range_end &&
        !modifiers.range_middle
      }
      className={cn(
        "min-w-(--cell-size) flex aspect-square size-auto w-full flex-col gap-1 font-normal leading-none",
        "dark:hover:text-accent-foreground",
        "data-[selected-single=true]:bg-primary data-[selected-single=true]:text-primary-foreground",
        "data-[range-end=true]:bg-primary data-[range-end=true]:text-primary-foreground data-[range-end=true]:rounded-md data-[range-end=true]:rounded-r-md",
        "data-[range-middle=true]:bg-accent data-[range-middle=true]:text-accent-foreground data-[range-middle=true]:rounded-none",
        "data-[range-start=true]:bg-primary data-[range-start=true]:text-primary-foreground data-[range-start=true]:rounded-md data-[range-start=true]:rounded-l-md",
        "group-data-[focused=true]/day:border-ring group-data-[focused=true]/day:ring-ring/50 group-data-[focused=true]/day:relative group-data-[focused=true]/day:z-10 group-data-[focused=true]/day:ring-2",
        "[&>span]:text-xs [&>span]:opacity-70",
        defaultClassNames.day,
        className,
      )}
      size="icon"
      variant="ghost"
      {...props}
    />
  );
}

export default CalendarDayButton;
