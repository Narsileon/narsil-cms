import { ButtonRoot, buttonRootVariants } from "@narsil-cms/components/button";
import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";
import { DayPicker, getDefaultClassNames } from "react-day-picker";
import CalendarDayButton from "./calendar-day-button";

type CalendarRootProps = ComponentProps<typeof DayPicker> & {
  buttonVariant?: ComponentProps<typeof ButtonRoot>["variant"];
};

function CalendarRoot({
  buttonVariant = "ghost",
  captionLayout = "label",
  className,
  classNames,
  components,
  formatters,
  showOutsideDays = true,
  ...props
}: CalendarRootProps) {
  const defaultClassNames = getDefaultClassNames();

  return (
    <DayPicker
      className={cn(
        "group/calendar bg-background p-3 [--cell-size:--spacing(8)]",
        "[[data-slot=card-content]_&]:bg-transparent",
        "[[data-slot=popover-content]_&]:bg-transparent",
        String.raw`rtl:**:[.rdp-button\_next>svg]:rotate-180`,
        String.raw`rtl:**:[.rdp-button\_previous>svg]:rotate-180`,
        className,
      )}
      classNames={{
        button_next: cn(
          buttonRootVariants({
            variant: buttonVariant,
          }),
          "size-(--cell-size) p-0 select-none aria-disabled:opacity-50",
          defaultClassNames.button_next,
        ),
        button_previous: cn(
          buttonRootVariants({
            variant: buttonVariant,
          }),
          "size-(--cell-size) p-0 select-none aria-disabled:opacity-50",
          defaultClassNames.button_previous,
        ),
        caption_label: cn(
          "flex h-(--cell-size) items-center gap-2 px-2 font-medium select-none",
          captionLayout === "label" &&
            "flex h-8 items-center gap-1 rounded-md pr-1 pl-2 [&>svg]:size-3.5 [&>svg]:text-muted-foreground",
          defaultClassNames.caption_label,
        ),
        day: cn(
          "group/day relative aspect-square h-full w-full p-0 text-center select-none",
          "[&:first-child[data-selected=true]_button]:rounded-l-md",
          "[&:last-child[data-selected=true]_button]:rounded-r-md",
          defaultClassNames.day,
        ),
        disabled: cn("text-muted-foreground opacity-50", defaultClassNames.disabled),
        dropdown: cn("absolute inset-0 bg-popover opacity-0", defaultClassNames.dropdown),
        dropdown_root: cn(
          "relative rounded-md border border-input shadow-sm has-focus:border-ring has-focus:ring-2 has-focus:ring-ring/50",
          defaultClassNames.dropdown_root,
        ),
        dropdowns: cn(
          "flex h-(--cell-size) w-full items-center justify-center gap-1.5 font-medium",
          defaultClassNames.dropdowns,
        ),
        hidden: cn("invisible", defaultClassNames.hidden),
        month: cn("flex w-full flex-col gap-4", defaultClassNames.month),
        month_caption: cn(
          "flex h-(--cell-size) w-full items-center justify-center px-(--cell-size)",
          defaultClassNames.month_caption,
        ),
        months: cn("relative flex flex-col gap-4 md:flex-row", defaultClassNames.months),
        nav: cn(
          "absolute inset-x-0 top-0 flex w-full items-center justify-between gap-1",
          defaultClassNames.nav,
        ),
        outside: cn(
          "text-muted-foreground aria-selected:text-muted-foreground",
          defaultClassNames.outside,
        ),
        range_start: cn("rounded-l-md bg-accent", defaultClassNames.range_start),
        range_middle: cn("rounded-none", defaultClassNames.range_middle),
        range_end: cn("rounded-r-md bg-accent", defaultClassNames.range_end),
        root: cn("w-fit", defaultClassNames.root),
        table: "w-full border-collapse",
        today: cn(
          "rounded-md bg-accent text-accent-foreground data-[selected=true]:rounded-none",
          defaultClassNames.today,
        ),
        week: cn("mt-2 flex w-full", defaultClassNames.week),
        weekday: cn(
          "flex-1 rounded-md text-[0.8rem] font-normal text-muted-foreground select-none",
          defaultClassNames.weekday,
        ),
        weekdays: cn("flex", defaultClassNames.weekdays),
        week_number: cn(
          "text-[0.8rem] text-muted-foreground select-none",
          defaultClassNames.week_number,
        ),
        week_number_header: cn("w-(--cell-size) select-none", defaultClassNames.week_number_header),
        ...classNames,
      }}
      components={{
        Root: ({ className, rootRef, ...props }) => {
          return (
            <div ref={rootRef} data-slot="calendar-root" className={cn(className)} {...props} />
          );
        },
        Chevron: ({ className, orientation, ...props }) => {
          return (
            <Icon
              className={cn("size-4", className)}
              name={
                orientation === "left"
                  ? "chevron-left"
                  : orientation === "right"
                    ? "chevron-right"
                    : "chevron-down"
              }
              {...props}
            />
          );
        },
        DayButton: CalendarDayButton,
        WeekNumber: ({ children, ...props }) => {
          return (
            <td {...props}>
              <div className="flex size-(--cell-size) items-center justify-center text-center">
                {children}
              </div>
            </td>
          );
        },
        ...components,
      }}
      captionLayout={captionLayout}
      formatters={{
        formatMonthDropdown: (date) => date.toLocaleString("default", { month: "short" }),
        ...formatters,
      }}
      showOutsideDays={showOutsideDays}
      {...props}
    />
  );
}

export default CalendarRoot;
