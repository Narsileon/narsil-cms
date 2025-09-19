import { CalendarRoot } from "@narsil-cms/components/calendar";

type CalendarProps = React.ComponentProps<typeof CalendarRoot> & {};

function Calendar({ ...props }: CalendarProps) {
  return <CalendarRoot {...props} />;
}

export default Calendar;
