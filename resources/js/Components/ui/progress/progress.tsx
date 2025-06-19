import { Indicator, Root } from "@radix-ui/react-progress";
import { cn } from "@/Components";

export type ProgressProps = React.ComponentProps<typeof Root> & {};

function Progress({ className, value, ...props }: ProgressProps) {
  return (
    <Root
      data-slot="progress"
      className={cn(
        "bg-primary/20 relative h-2 w-full overflow-hidden rounded-full",
        className,
      )}
      {...props}
    >
      <Indicator
        data-slot="progress-indicator"
        className="bg-primary h-full w-full flex-1 transition-all"
        style={{ transform: `translateX(-${100 - (value || 0)}%)` }}
      />
    </Root>
  );
}
export default Progress;
