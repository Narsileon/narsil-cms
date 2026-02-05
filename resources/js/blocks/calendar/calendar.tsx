import { CalendarRoot } from "@narsil-ui/components/calendar";
import { type ComponentProps } from "react";

type CalendarProps = ComponentProps<typeof CalendarRoot>;

function Calendar({ ...props }: CalendarProps) {
  return <CalendarRoot {...props} />;
}

export default Calendar;
