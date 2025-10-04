import { type ComponentProps } from "react";

import { CalendarRoot } from "@narsil-cms/components/calendar";

type CalendarProps = ComponentProps<typeof CalendarRoot>;

function Calendar({ ...props }: CalendarProps) {
  return <CalendarRoot {...props} />;
}

export default Calendar;
